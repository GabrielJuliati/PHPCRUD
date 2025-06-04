package relatorio.model;

public class Relatorio {
    private int id;
    private Paciente paciente;
    private String tipoExame;
    private String dataExame;

    public Relatorio(int id, Paciente paciente, String tipoExame, String dataExame) {
        this.id = id;
        this.paciente = paciente;
        this.tipoExame = tipoExame;
        this.dataExame = dataExame;
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

    @Override
    public String toString() {
        return id + " - " + paciente.getNome() + " - " + tipoExame + " - " + dataExame;
    }
}
