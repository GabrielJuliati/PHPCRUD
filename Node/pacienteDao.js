const mysql = require('mysql2/promise');

class PacienteDao {
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

    async inserir(nome, cpf, telefone, endereco, observacoes, dataNascimento) {
        let connection;
        try {
            connection = await this.getConnection();
            const sql = `INSERT INTO paciente (nome, cpf, telefone, endereco, observacoes, data_nascimento)
                         VALUES (?, ?, ?, ?, ?, ?)`;
            const [result] = await connection.execute(sql, [nome, cpf, telefone, endereco, observacoes, dataNascimento]);
            return result;
        } catch (error) {
            console.error('Erro ao inserir paciente:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }

    async listarTodos() {
        let connection;
        try {
            connection = await this.getConnection();
            const sql = 'SELECT * FROM paciente';
            const [rows] = await connection.execute(sql);
            return rows;
        } catch (error) {
            console.error('Erro ao listar pacientes:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }

    async atualizar(id, nome, cpf, telefone, endereco, observacoes, dataNascimento) {
        let connection;
        try {
            connection = await this.getConnection();
            const sql = `UPDATE paciente 
                         SET nome = ?, cpf = ?, telefone = ?, endereco = ?, 
                             observacoes = ?, data_nascimento = ?
                         WHERE id = ?`;
            const [result] = await connection.execute(sql, [nome, cpf, telefone, endereco, observacoes, dataNascimento, id]);
            return result;
        } catch (error) {
            console.error('Erro ao atualizar paciente:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }

    async delete(id) {
        let connection;
        try {
            connection = await this.getConnection();
            const sql = 'DELETE FROM paciente WHERE id = ?';
            const [result] = await connection.execute(sql, [id]);
            return result;
        } catch (error) {
            console.error('Erro ao excluir paciente:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }

    async buscarPorCpf(cpf) {
        let connection;
        try {
            connection = await this.getConnection();
            const sql = 'SELECT * FROM paciente WHERE cpf LIKE ?';
            const [rows] = await connection.execute(sql, [`%${cpf}%`]);
            return rows;
        } catch (error) {
            console.error('Erro ao buscar paciente por CPF:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }

    async buscarPorId(id) {
        let connection;
        try {
            connection = await this.getConnection();
            const sql = 'SELECT * FROM paciente WHERE id = ?';
            const [rows] = await connection.execute(sql, [id]);
            return rows[0];
        } catch (error) {
            console.error('Erro ao buscar paciente por ID:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }
}

module.exports = PacienteDao;

