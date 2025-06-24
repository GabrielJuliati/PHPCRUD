package relatorio.model;

/**
 * Representa um Relatório com detalhes de um exame e paciente.
 */
public class Relatorio {
    private int id;
    private Paciente paciente;
    private String tipoExame;
    private String dataExame;
    private String cpfPaciente;
    private String resultado;
    private String observacao;

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
               " | CPF: " + cpfPaciente +
               " | Tipo Exame: " + tipoExame +
               " | Data Exame: " + dataExame +
               " | Resultado: " + resultado +
               " | Observação: " + (observacao != null && !observacao.isEmpty() ? observacao : "N/A");
    }
}
