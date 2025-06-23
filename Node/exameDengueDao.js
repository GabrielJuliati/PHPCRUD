const mysql = require('mysql2/promise');

class ExameDengueDao {
    constructor() {
        this.config = {
            host: 'localhost',
            user: 'root',
            password: '',
            database: 'sps',
            port: 3306
        };
    }

    async getConnection() {
        try {
            return await mysql.createConnection(this.config);
        } catch (error) {
            console.error('Erro ao conectar com o banco de dados:', error);
            throw error;
        }
    }

    async inserir(exameData) {
        let connection;
        try {
            connection = await this.getConnection();
            const sql = `INSERT INTO exame_dengue 
                         (agendamento_id, paciente_id, nome, amostra_sangue, data_inicio_sintomas) 
                         VALUES (?, ?, ?, ?, ?)`;
            const [result] = await connection.execute(sql, [
                exameData.agendamento_id,
                exameData.paciente_id,
                exameData.nome,
                exameData.amostra_sangue,
                exameData.data_inicio_sintomas
            ]);
            return { id: result.insertId, ...exameData };
        } catch (error) {
            console.error('Erro ao inserir exame de dengue:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }

    async buscarPorId(id) {
        let connection;
        try {
            connection = await this.getConnection();
            const sql = `SELECT * FROM exame_dengue WHERE id = ?`;
            const [rows] = await connection.execute(sql, [id]);
            
            if (rows.length === 0) return null;
            
            return {
                ...rows[0],
                tipoExame: 'Dengue'
            };
        } catch (error) {
            console.error('Erro ao buscar exame de dengue por ID:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }

    async buscarPorAgendamento(agendamentoId) {
        let connection;
        try {
            connection = await this.getConnection();
            const sql = `SELECT * FROM exame_dengue WHERE agendamento_id = ?`;
            const [rows] = await connection.execute(sql, [agendamentoId]);
            
            return rows.map(row => ({
                ...row,
                tipoExame: 'Dengue'
            }));
        } catch (error) {
            console.error('Erro ao buscar exames de dengue por agendamento:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }

    async buscarTodos() {
    let connection;
    try {
        connection = await this.getConnection();
        const sql = `
            SELECT 
                ed.id,
                ed.agendamento_id,
                ed.paciente_id,
                ed.nome,
                ed.amostra_sangue,
                ed.data_inicio_sintomas,
                a.data_consulta,
                p.nome as paciente_nome, 
                p.cpf as paciente_cpf 
            FROM exame_dengue ed
            LEFT JOIN agendamento a ON ed.agendamento_id = a.id
            LEFT JOIN paciente p ON ed.paciente_id = p.id
            ORDER BY ed.id DESC`;
        
        const [rows] = await connection.execute(sql);
        
        // Verifica se há resultados
        if (!rows || rows.length === 0) {
            return [];
        }

        // Mapeia os resultados garantindo que todos os campos existam
        return rows.map(row => {
            const exame = {
                id: row.id,
                agendamento_id: row.agendamento_id || null,
                paciente_id: row.paciente_id || null,
                nome: row.nome || '',
                amostra_sangue: row.amostra_sangue || '',
                data_inicio_sintomas: row.data_inicio_sintomas || null,
                tipoExame: 'Dengue',
                dataConsulta: row.data_consulta || null,
                pacienteNome: row.paciente_nome || '',
                pacienteCpf: row.paciente_cpf || ''
            };
            
            // Verifica se as datas são válidas
            if (exame.dataConsulta instanceof Date === false && exame.dataConsulta) {
                exame.dataConsulta = new Date(exame.dataConsulta);
            }
            if (exame.data_inicio_sintomas instanceof Date === false && exame.data_inicio_sintomas) {
                exame.data_inicio_sintomas = new Date(exame.data_inicio_sintomas);
            }
            
            return exame;
        });
        
    } catch (error) {
        console.error('Erro detalhado ao buscar exames de dengue:', {
            message: error.message,
            sql: error.sql,
            stack: error.stack
        });
        throw new Error('Falha ao buscar exames de dengue. Por favor, tente novamente mais tarde.');
    } finally {
        if (connection && connection.end) {
            try {
                await connection.end();
            } catch (endError) {
                console.error('Erro ao fechar conexão:', endError);
            }
        }
    }
}

    async atualizar(exameData) {
        let connection;
        try {
            connection = await this.getConnection();
            const sql = `UPDATE exame_dengue 
                         SET nome = ?, amostra_sangue = ?, data_inicio_sintomas = ?
                         WHERE id = ?`;
            const [result] = await connection.execute(sql, [
                exameData.nome,
                exameData.amostra_sangue,
                exameData.data_inicio_sintomas,
                exameData.id
            ]);
            return result.affectedRows > 0;
        } catch (error) {
            console.error('Erro ao atualizar exame de dengue:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }

    async deletar(id) {
        let connection;
        try {
            connection = await this.getConnection();
            const sql = 'DELETE FROM exame_dengue WHERE id = ?';
            const [result] = await connection.execute(sql, [id]);
            return result.affectedRows > 0;
        } catch (error) {
            console.error('Erro ao deletar exame de dengue:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }
}

module.exports = ExameDengueDao;