package model;

import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;

public class Agendamento {
    private int id;
    private String nome;
    private LocalDateTime dataConsulta;
    private String tipoExame;

    public Agendamento() {
    }

    public Agendamento(int id, String nome, LocalDateTime dataConsulta, String tipoExame) {
        this.id = id;
        this.nome = nome;
        this.dataConsulta = dataConsulta;
        this.tipoExame = tipoExame;
    }

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

    public LocalDateTime getDataConsulta() {
        return dataConsulta;
    }

    public void setDataConsulta(LocalDateTime dataConsulta) {
        this.dataConsulta = dataConsulta;
    }

    public String getTipoExame() {
        return tipoExame;
    }

    public void setTipoExame(String tipoExame) {
        this.tipoExame = tipoExame;
    }

    @Override
    public String toString() {
        return "Agendamento{" +
                "id=" + id +
                ", nome='" + nome + '\'' +
                ", dataConsulta=" + dataConsulta.format(DateTimeFormatter.ofPattern("dd/MM/yyyy HH:mm")) +
                ", tipoExame='" + tipoExame + '\'' +
                '}';
    }
}
