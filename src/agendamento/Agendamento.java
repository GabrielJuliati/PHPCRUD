import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;

public class Agendamento {
    private int id;
    private LocalDateTime dataConsulta;
    private int pacienteId;
    private String pacienteNome;
    private String pacienteCpf;
    private String tipoExame;

    // Construtores
    public Agendamento() {
    }

    public Agendamento(int id, LocalDateTime dataConsulta, int pacienteId, 
                      String pacienteNome, String pacienteCpf, String tipoExame) {
        this.id = id;
        this.dataConsulta = dataConsulta;
        this.pacienteId = pacienteId;
        this.pacienteNome = pacienteNome;
        this.pacienteCpf = pacienteCpf;
        this.tipoExame = tipoExame;
    }

    // Getters e Setters
    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public LocalDateTime getDataConsulta() {
        return dataConsulta;
    }

    public void setDataConsulta(LocalDateTime dataConsulta) {
        this.dataConsulta = dataConsulta;
    }

    public int getPacienteId() {
        return pacienteId;
    }

    public void setPacienteId(int pacienteId) {
        this.pacienteId = pacienteId;
    }

    public String getPacienteNome() {
        return pacienteNome;
    }

    public void setPacienteNome(String pacienteNome) {
        this.pacienteNome = pacienteNome;
    }

    public String getPacienteCpf() {
        return pacienteCpf;
    }

    public void setPacienteCpf(String pacienteCpf) {
        this.pacienteCpf = pacienteCpf;
    }

    public String getTipoExame() {
        return tipoExame;
    }

    public void setTipoExame(String tipoExame) {
        this.tipoExame = tipoExame;
    }

    @Override
    public String toString() {
        DateTimeFormatter formatter = DateTimeFormatter.ofPattern("dd/MM/yyyy HH:mm");
        return "Agendamento{" +
                "id=" + id +
                ", dataConsulta=" + dataConsulta.format(formatter) +
                ", pacienteId=" + pacienteId +
                ", pacienteNome='" + pacienteNome + '\'' +
                ", pacienteCpf='" + pacienteCpf + '\'' +
                ", tipoExame='" + tipoExame + '\'' +
                '}';
    }
}