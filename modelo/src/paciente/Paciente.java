package paciente;

import java.sql.Date;

public class Paciente {
    private int id;
    private String nome;
    private Date dataNascimento;
    private String endereco;
    private String telefone;
    private String cpf;
    private String obs;


    public int getId() {
        return id;
    }
    public void setId(int id) {
        this.id = id;
    }
    public String getNome() {
        return nome;
    }
    public void setNome(String nome) {
        this.nome = nome;
    }
    public Date getDataNascimento() {
        return dataNascimento;
    }
    public void setDataNascimento(Date dataNascimento) {
        this.dataNascimento = dataNascimento;
    }
    public String getEndereco() {
        return endereco;
    }
    public void setEndereco(String endereco) {
        this.endereco = endereco;
    }
    public String getTelefone() {
        return telefone;
    }
    public void setTelefone(String telefone) {
        this.telefone = telefone;
    }
    public String getCpf() {
        return cpf;
    }
    public void setCpf(String cpf) {
        this.cpf = cpf;
    }
    public String getObs() {
        return obs;
    }
    public void setObs(String obs) {
        this.obs = obs;
    }

    public String insert() {
        return "INSERT INTO paciente (nome, data_nascimento, endereco, telefone, CPF, observacoes) VALUES ('" + nome + "', '" + dataNascimento + "', '" + endereco + "', '" + telefone + "', '" + cpf + "', '" + obs + "');";
    }
}
