const mysql = require('mysql2/promise');

// Importação correta do date-fns
const { format } = require('date-fns');

function formatarData(data) {
    return format(new Date(data), 'dd/MM/yyyy');
}

function formataDataEUA(data) {
    return format(new Date(data), 'yyyy/MM/dd');
}

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
            const [result] = await connection.execute(sql);
            const pacientes = result.map(paciente => {
                paciente.data_nascimento = formatarData(paciente.data_nascimento);
                return paciente;
            });
            return pacientes;
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
            const [result] = await connection.execute(sql, [`%${cpf}%`]);
            const pacientes = result.map(paciente => {
                paciente.data_nascimento = formatarData(paciente.data_nascimento);
                return paciente;
            });
            return pacientes;
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
            const [result] = await connection.execute(sql, [id]);
            const pacientes = result.map(paciente => {
                paciente.data_nascimento = formataDataEUA(paciente.data_nascimento);
                return paciente;
            });
            return pacientes[0];
        } catch (error) {
            console.error('Erro ao buscar paciente por ID:', error);
            throw error;
        } finally {
            if (connection) await connection.end();
        }
    }
}

module.exports = PacienteDao;