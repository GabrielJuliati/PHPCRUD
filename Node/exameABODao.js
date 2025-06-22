const mysql = require('mysql2/promise');

class ExameABODao {
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
            const sql = `INSERT INTO exame_abo 
                         (agendamento_id, paciente_id, nome, amostra_dna, tipo_sanguineo, observacoes) 
                         VALUES (?, ?, ?, ?, ?, ?)`;
            const [result] = await connection.execute(sql, [
                exameData.agendamento_id,
                exameData.paciente_id,
                exameData.nome,
                exameData.amostra_dna,
                exameData.tipo_sanguineo,
                exameData.observacoes
            ]);
            return { id: result.insertId, ...exameData };
        } catch (error) {
            console.error('Erro ao inserir exame ABO:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }

    async buscarPorId(id) {
        let connection;
        try {
            connection = await this.getConnection();
            const sql = `SELECT * FROM exame_abo WHERE id = ?`;
            const [rows] = await connection.execute(sql, [id]);
            
            if (rows.length === 0) return null;
            
            return {
                ...rows[0],
                tipoExame: 'ABO'
            };
        } catch (error) {
            console.error('Erro ao buscar exame ABO por ID:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }

    async buscarPorAgendamento(agendamentoId) {
        let connection;
        try {
            connection = await this.getConnection();
            const sql = `SELECT * FROM exame_abo WHERE agendamento_id = ?`;
            const [rows] = await connection.execute(sql, [agendamentoId]);
            
            return rows.map(row => ({
                ...row,
                tipoExame: 'ABO'
            }));
        } catch (error) {
            console.error('Erro ao buscar exames ABO por agendamento:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }

    async buscarTodos() {
        let connection;
        try {
            connection = await this.getConnection();
            const sql = `SELECT ea.*, a.data_consulta, p.nome as paciente_nome, p.cpf as paciente_cpf 
                         FROM exame_abo ea
                         LEFT JOIN agendamento a ON ea.agendamento_id = a.id
                         LEFT JOIN paciente p ON ea.paciente_id = p.id
                         ORDER BY ea.id DESC`;
            const [rows] = await connection.execute(sql);
            
            return rows.map(row => ({
                ...row,
                tipoExame: 'ABO',
                dataConsulta: row.data_consulta,
                pacienteNome: row.paciente_nome,
                pacienteCpf: row.paciente_cpf
            }));
        } catch (error) {
            console.error('Erro ao buscar todos os exames ABO:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }

    async atualizar(exameData) {
        let connection;
        try {
            connection = await this.getConnection();
            const sql = `UPDATE exame_abo 
                         SET nome = ?, amostra_dna = ?, tipo_sanguineo = ?, observacoes = ?
                         WHERE id = ?`;
            const [result] = await connection.execute(sql, [
                exameData.nome,
                exameData.amostra_dna,
                exameData.tipo_sanguineo,
                exameData.observacoes,
                exameData.id
            ]);
            return result.affectedRows > 0;
        } catch (error) {
            console.error('Erro ao atualizar exame ABO:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }

    async deletar(id) {
        let connection;
        try {
            connection = await this.getConnection();
            const sql = 'DELETE FROM exame_abo WHERE id = ?';
            const [result] = await connection.execute(sql, [id]);
            return result.affectedRows > 0;
        } catch (error) {
            console.error('Erro ao deletar exame ABO:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }
}

module.exports = ExameABODao;