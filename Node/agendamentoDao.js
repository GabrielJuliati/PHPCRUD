const mysql = require('mysql2/promise');

class AgendamentoDao {
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
            const connection = await mysql.createConnection(this.config);
            return connection;
        } catch (error) {
            console.error('Erro ao conectar com o banco de dados:', error);
            throw error;
        }
    }

    async read() {
        let connection;
        try {
            connection = await this.getConnection();
            const sql = `SELECT a.id, a.data_consulta, a.tipo_exame, a.paciente_id,
                                p.nome AS paciente_nome, p.cpf AS paciente_cpf 
                         FROM agendamento a 
                         JOIN paciente p ON a.paciente_id = p.id
                         ORDER BY a.id DESC`;
            const [rows] = await connection.execute(sql);
            return rows;
        } catch (error) {
            console.error('Erro ao listar agendamentos:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }

    async buscarPorCpf(cpf) {
        let connection;
        try {
            connection = await this.getConnection();
            const sql = `SELECT a.id, a.data_consulta, a.tipo_exame, a.paciente_id,
                                p.nome AS paciente_nome, p.cpf AS paciente_cpf 
                         FROM agendamento a 
                         JOIN paciente p ON a.paciente_id = p.id 
                         WHERE p.cpf LIKE ?
                         ORDER BY a.id DESC`;
            const [rows] = await connection.execute(sql, [`%${cpf}%`]);
            return rows;
        } catch (error) {
            console.error('Erro ao buscar agendamentos por CPF:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }

    async buscarPorId(id) {
        let connection;
        try {
            connection = await this.getConnection();
            const sql = `SELECT a.id, a.data_consulta, a.tipo_exame, a.paciente_id,
                                p.nome AS paciente_nome, p.cpf AS paciente_cpf 
                         FROM agendamento a 
                         JOIN paciente p ON a.paciente_id = p.id 
                         WHERE a.id = ?`;
            const [rows] = await connection.execute(sql, [id]);
            return rows[0];
        } catch (error) {
            console.error('Erro ao buscar agendamento por ID:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }

    async inserir(pacienteId, dataConsulta, tipoExame) {
        let connection;
        try {
            connection = await this.getConnection();
            const sql = `INSERT INTO agendamento (paciente_id, data_consulta, tipo_exame)
                         VALUES (?, ?, ?)`;
            const [result] = await connection.execute(sql, [pacienteId, dataConsulta, tipoExame]);
            return result;
        } catch (error) {
            console.error('Erro ao inserir agendamento:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }

    async atualizar(id, pacienteId, dataConsulta, tipoExame) {
        let connection;
        try {
            connection = await this.getConnection();
            const sql = `UPDATE agendamento 
                         SET paciente_id = ?, data_consulta = ?, tipo_exame = ?
                         WHERE id = ?`;
            const [result] = await connection.execute(sql, [pacienteId, dataConsulta, tipoExame, id]);
            return result;
        } catch (error) {
            console.error('Erro ao atualizar agendamento:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }

    async delete(id) {
        let connection;
        try {
            connection = await this.getConnection();
            const sql = 'DELETE FROM agendamento WHERE id = ?';
            const [result] = await connection.execute(sql, [id]);
            return result;
        } catch (error) {
            console.error('Erro ao excluir agendamento:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }
}

module.exports = AgendamentoDao;

