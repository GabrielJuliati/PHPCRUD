package relatorio.model;

public class Relatorio {
    private int id;
    private Paciente paciente;
    private String tipoExame;
    private String dataExame;
    private String cpfPaciente; // NOVO CAMPO: CPF do paciente
    private String resultado;   // NOVO CAMPO: Resultado do exame
    private String observacao;  // NOVO CAMPO: Observações

    // Construtor atualizado com os novos campos
    public Relatorio(int id, Paciente paciente, String tipoExame, String dataExame,
                     String cpfPaciente, String resultado, String observacao) {
        this.id = id;
        this.paciente = paciente;
        this.tipoExame = tipoExame;
        this.dataExame = dataExame;
        this.cpfPaciente = cpfPaciente;
        this.resultado = resultado;
        this.observacao = observacao;
    }

    public int getId() {
        return id;
    }

    // Não há setId(int id) público pois o ID é gerado internamente e não deve ser alterado após criação.

    public Paciente getPaciente() {
        return paciente;
    }

    public String getTipoExame() {
        return tipoExame;
    }

    public void setTipoExame(String tipoExame) {
        this.tipoExame = tipoExame;
    }

    public String getDataExame() {
        return dataExame;
    }

    public void setDataExame(String dataExame) {
        this.dataExame = dataExame;
    }

    // NOVOS GETTERS E SETTERS
    public String getCpfPaciente() {
        return cpfPaciente;
    }

    public void setCpfPaciente(String cpfPaciente) {
        this.cpfPaciente = cpfPaciente;
    }

    public String getResultado() {
        return resultado;
    }

    public void setResultado(String resultado) {
        this.resultado = resultado;
    }

    public String getObservacao() {
        return observacao;
    }

    public void setObservacao(String observacao) {
        this.observacao = observacao;
    }

    @Override
    public String toString() {
        return "ID: " + id +
               " | Paciente: " + paciente.getNome() +
               " | CPF: " + cpfPaciente + // Inclui o CPF no toString
               " | Tipo Exame: " + tipoExame +
               " | Data Exame: " + dataExame +
               " | Resultado: " + resultado + // Inclui o resultado
               " | Observação: " + (observacao != null && !observacao.isEmpty() ? observacao : "N/A"); // Inclui observação
    }
}