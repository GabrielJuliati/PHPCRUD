const mysql = require('mysql2/promise');

class ExameCovidDao {
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
            const sql = `INSERT INTO exame_covid_19 
                         (agendamento_id, paciente_id, nome, tipo_teste, status_amostra, 
                          resultado, data_inicio_sintomas, sintomas, observacoes) 
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)`;
            const [result] = await connection.execute(sql, [
                exameData.agendamento_id,
                exameData.paciente_id,
                exameData.nome,
                exameData.tipo_teste,
                exameData.status_amostra,
                exameData.resultado,
                exameData.data_inicio_sintomas,
                exameData.sintomas,
                exameData.observacoes
            ]);
            return { id: result.insertId, ...exameData };
        } catch (error) {
            console.error('Erro ao inserir exame COVID-19:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }

    async buscarPorId(id) {
        let connection;
        try {
            connection = await this.getConnection();
            const sql = `SELECT * FROM exame_covid_19 WHERE id = ?`;
            const [rows] = await connection.execute(sql, [id]);
            
            if (rows.length === 0) return null;
            
            return {
                ...rows[0],
                tipoExame: 'COVID-19'
            };
        } catch (error) {
            console.error('Erro ao buscar exame COVID-19 por ID:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }

    async buscarPorAgendamento(agendamentoId) {
        let connection;
        try {
            connection = await this.getConnection();
            const sql = `SELECT * FROM exame_covid_19 WHERE agendamento_id = ?`;
            const [rows] = await connection.execute(sql, [agendamentoId]);
            
            return rows.map(row => ({
                ...row,
                tipoExame: 'COVID-19'
            }));
        } catch (error) {
            console.error('Erro ao buscar exames COVID-19 por agendamento:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }

    async buscarTodos() {
        let connection;
        try {
            connection = await this.getConnection();
            const sql = `SELECT ec.*, a.data_consulta, p.nome as paciente_nome, p.cpf as paciente_cpf 
                         FROM exame_covid_19 ec
                         LEFT JOIN agendamento a ON ec.agendamento_id = a.id
                         LEFT JOIN paciente p ON ec.paciente_id = p.id
                         ORDER BY ec.id DESC`;
            const [rows] = await connection.execute(sql);
            
            return rows.map(row => ({
                ...row,
                tipoExame: 'COVID-19',
                dataConsulta: row.data_consulta,
                pacienteNome: row.paciente_nome,
                pacienteCpf: row.paciente_cpf
            }));
        } catch (error) {
            console.error('Erro ao buscar todos os exames COVID-19:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }

    async atualizar(exameData) {
        let connection;
        try {
            connection = await this.getConnection();
            const sql = `UPDATE exame_covid_19 
                         SET nome = ?, tipo_teste = ?, status_amostra = ?, 
                             resultado = ?, data_inicio_sintomas = ?, 
                             sintomas = ?, observacoes = ?
                         WHERE id = ?`;
            const [result] = await connection.execute(sql, [
                exameData.nome,
                exameData.tipo_teste,
                exameData.status_amostra,
                exameData.resultado,
                exameData.data_inicio_sintomas,
                exameData.sintomas,
                exameData.observacoes,
                exameData.id
            ]);
            return result.affectedRows > 0;
        } catch (error) {
            console.error('Erro ao atualizar exame COVID-19:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }

    async deletar(id) {
        let connection;
        try {
            connection = await this.getConnection();
            const sql = 'DELETE FROM exame_covid_19 WHERE id = ?';
            const [result] = await connection.execute(sql, [id]);
            return result.affectedRows > 0;
        } catch (error) {
            console.error('Erro ao deletar exame COVID-19:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }
}

module.exports = ExameCovidDao;