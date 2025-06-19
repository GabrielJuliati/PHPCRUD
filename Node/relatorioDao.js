const mysql = require('mysql2/promise');
const PacienteDao = require('./pacienteDao');
const AgendamentoDao = require('./agendamentoDao');

class RelatorioDao {
    constructor() {
        this.config = {
            host: 'localhost',
            user: 'root',
            password: '',
            database: 'sps',
            port: 3306
        };
        this.pacienteDao = new PacienteDao();
        this.agendamentoDao = new AgendamentoDao();
    }

    async getConnection() {
        try {
            const connection = await mysql.createConnection(this.config);
            return connection;
        } catch (error) {
            console.error('Erro ao conectar com o banco de dados:', error);
            throw error;
        }
    }

    /**
     * Busca relatórios por CPF do paciente
     * @param {string} cpf - CPF do paciente
     * @returns {Array} Lista de relatórios do paciente
     */
    async buscarPorCpf(cpf) {
        let connection;
        try {
            connection = await this.getConnection();
            
            // Busca relatórios pela tabela de relatórios
            // Usando REPLACE para remover pontos e traços do CPF armazenado no banco
            const sql = `
                SELECT * FROM relatorios 
                WHERE REPLACE(REPLACE(REPLACE(cpf, '.', ''), '-', ''), ' ', '') LIKE ?
                ORDER BY data_exame DESC
            `;
            
            // Remove qualquer formatação do CPF de busca
            const cpfLimpo = cpf.replace(/\D/g, '');
            
            const [rows] = await connection.execute(sql, [`%${cpfLimpo}%`]);
            return rows;
        } catch (error) {
            console.error('Erro ao buscar relatórios por CPF:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }

    /**
     * Busca pacientes por CPF de forma robusta à formatação
     * @param {string} cpf - CPF do paciente
     * @returns {Array} Lista de pacientes encontrados
     */
    async buscarPacientePorCpfRobusto(cpf) {
        let connection;
        try {
            connection = await this.getConnection();
            
            // Remove qualquer formatação do CPF de busca
            const cpfLimpo = cpf.replace(/\D/g, '');
            
            // Busca pacientes usando uma consulta SQL que remove formatação do CPF armazenado
            const sql = `
                SELECT * FROM paciente 
                WHERE REPLACE(REPLACE(REPLACE(CPF, '.', ''), '-', ''), ' ', '') LIKE ?
            `;
            
            const [rows] = await connection.execute(sql, [`%${cpfLimpo}%`]);
            return rows;
        } catch (error) {
            console.error('Erro ao buscar paciente por CPF de forma robusta:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }

    /**
     * Busca agendamentos por CPF de forma robusta à formatação
     * @param {string} cpf - CPF do paciente
     * @returns {Array} Lista de agendamentos encontrados
     */
    async buscarAgendamentosPorCpfRobusto(cpf) {
        let connection;
        try {
            connection = await this.getConnection();
            
            // Remove qualquer formatação do CPF de busca
            const cpfLimpo = cpf.replace(/\D/g, '');
            
            // Busca agendamentos usando uma consulta SQL que remove formatação do CPF armazenado
            const sql = `
                SELECT a.id, a.data_consulta, a.tipo_exame, a.paciente_id,
                       p.nome AS paciente_nome, p.CPF AS paciente_cpf 
                FROM agendamento a 
                JOIN paciente p ON a.paciente_id = p.id 
                WHERE REPLACE(REPLACE(REPLACE(p.CPF, '.', ''), '-', ''), ' ', '') LIKE ?
                ORDER BY a.id DESC
            `;
            
            const [rows] = await connection.execute(sql, [`%${cpfLimpo}%`]);
            return rows;
        } catch (error) {
            console.error('Erro ao buscar agendamentos por CPF de forma robusta:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }

    /**
     * Gera relatório consolidado de um paciente por CPF
     * @param {string} cpf - CPF do paciente
     * @returns {Object} Relatório consolidado do paciente
     */
    async gerarRelatorioConsolidadoPorCpf(cpf) {
        try {
            // Remove qualquer formatação do CPF
            const cpfLimpo = cpf.replace(/\D/g, '');
            
            // Busca dados do paciente usando o método robusto
            const pacientes = await this.buscarPacientePorCpfRobusto(cpfLimpo);
            
            if (pacientes.length === 0) {
                return {
                    success: false,
                    message: 'Paciente não encontrado'
                };
            }
            
            const paciente = pacientes[0];
            
            // Busca agendamentos do paciente usando o método robusto
            const agendamentos = await this.buscarAgendamentosPorCpfRobusto(cpfLimpo);
            
            // Busca relatórios do paciente
            const relatorios = await this.buscarPorCpf(cpfLimpo);
            
            // Estatísticas de agendamentos
            const totalAgendamentos = agendamentos.length;
            
            // Agrupar agendamentos por tipo de exame
            const agendamentosPorTipo = {};
            agendamentos.forEach(agendamento => {
                const tipo = agendamento.tipo_exame;
                if (!agendamentosPorTipo[tipo]) {
                    agendamentosPorTipo[tipo] = 0;
                }
                agendamentosPorTipo[tipo]++;
            });
            
            // Estatísticas de relatórios
            const totalRelatorios = relatorios.length;
            
            // Agrupar relatórios por resultado
            const relatoriosPorResultado = {};
            relatorios.forEach(relatorio => {
                const resultado = relatorio.resultado;
                if (!relatoriosPorResultado[resultado]) {
                    relatoriosPorResultado[resultado] = 0;
                }
                relatoriosPorResultado[resultado]++;
            });
            
            // Agrupar relatórios por tipo de exame
            const relatoriosPorTipo = {};
            relatorios.forEach(relatorio => {
                const tipo = relatorio.tipo_exame;
                if (!relatoriosPorTipo[tipo]) {
                    relatoriosPorTipo[tipo] = 0;
                }
                relatoriosPorTipo[tipo]++;
            });
            
            return {
                paciente: paciente,
                estatisticas: {
                    totalAgendamentos,
                    agendamentosPorTipo,
                    totalRelatorios,
                    relatoriosPorResultado,
                    relatoriosPorTipo
                },
                agendamentos: agendamentos,
                relatorios: relatorios
            };
        } catch (error) {
            console.error('Erro ao gerar relatório consolidado por CPF:', error);
            throw error;
        }
    }

    /**
     * Método para buscar dados consolidados por CPF (compatível com a API)
     * Este é o método que estava faltando e causando o erro
     * @param {string} cpf - CPF do paciente
     * @returns {Object} Dados consolidados do paciente
     */
    async buscarDadosConsolidadosPorCpf(cpf) {
        try {
            // Remove qualquer formatação do CPF
            const cpfLimpo = cpf.replace(/\D/g, '');
            
            // Busca dados do paciente usando o método robusto
            const pacientes = await this.buscarPacientePorCpfRobusto(cpfLimpo);
            
            if (pacientes.length === 0) {
                return {
                    paciente: null,
                    agendamentos: [],
                    relatorios: []
                };
            }
            
            const paciente = pacientes[0];
            
            // Busca agendamentos do paciente usando o método robusto
            const agendamentos = await this.buscarAgendamentosPorCpfRobusto(cpfLimpo);
            
            // Busca relatórios do paciente
            const relatorios = await this.buscarPorCpf(cpfLimpo);
            
            return {
                paciente,
                agendamentos,
                relatorios
            };
        } catch (error) {
            console.error('Erro ao buscar dados consolidados por CPF:', error);
            throw error;
        }
    }

    /**
     * Lista todos os relatórios
     * @returns {Array} Lista de relatórios
     */
    async listarTodos() {
        let connection;
        try {
            connection = await this.getConnection();
            
            const sql = 'SELECT * FROM relatorios ORDER BY data_exame DESC';
            
            const [rows] = await connection.execute(sql);
            return rows;
        } catch (error) {
            console.error('Erro ao listar relatórios:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }

    /**
     * Busca um relatório por ID
     * @param {number} id - ID do relatório
     * @returns {Object} Relatório encontrado
     */
    async buscarPorId(id) {
        let connection;
        try {
            connection = await this.getConnection();
            
            const sql = 'SELECT * FROM relatorios WHERE id = ?';
            
            const [rows] = await connection.execute(sql, [id]);
            
            if (rows.length === 0) {
                return null;
            }
            
            return rows[0];
        } catch (error) {
            console.error('Erro ao buscar relatório por ID:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }

    /**
     * Adiciona um novo relatório
     * @param {Object} dados - Dados do relatório
     * @returns {Object} Resultado da operação
     */
    async inserir(nome_paciente, cpf, tipo_exame, data_exame, resultado, observacao) {
        let connection;
        try {
            connection = await this.getConnection();
            
            const sql = `
                INSERT INTO relatorios 
                (nome_paciente, cpf, tipo_exame, data_exame, resultado, observacao)
                VALUES (?, ?, ?, ?, ?, ?)
            `;
            
            const [result] = await connection.execute(sql, [
                nome_paciente, 
                cpf, 
                tipo_exame, 
                data_exame, 
                resultado, 
                observacao || ''
            ]);
            
            return result;
        } catch (error) {
            console.error('Erro ao adicionar relatório:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }

    /**
     * Atualiza um relatório existente
     * @param {Object} dados - Dados do relatório
     * @returns {Object} Resultado da operação
     */
    async atualizar(id, nome_paciente, cpf, tipo_exame, data_exame, resultado, observacao) {
        let connection;
        try {
            connection = await this.getConnection();
            
            const sql = `
                UPDATE relatorios 
                SET nome_paciente = ?, 
                    cpf = ?, 
                    tipo_exame = ?, 
                    data_exame = ?, 
                    resultado = ?, 
                    observacao = ?
                WHERE id = ?
            `;
            
            const [result] = await connection.execute(sql, [
                nome_paciente, 
                cpf, 
                tipo_exame, 
                data_exame, 
                resultado, 
                observacao || '',
                id
            ]);
            
            return result;
        } catch (error) {
            console.error('Erro ao atualizar relatório:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }

    /**
     * Exclui um relatório
     * @param {number} id - ID do relatório
     * @returns {Object} Resultado da operação
     */
    async excluir(id) {
        let connection;
        try {
            connection = await this.getConnection();
            
            const sql = 'DELETE FROM relatorios WHERE id = ?';
            
            const [result] = await connection.execute(sql, [id]);
            
            return result;
        } catch (error) {
            console.error('Erro ao excluir relatório:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }
}

module.exports = RelatorioDao;

