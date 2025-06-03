package relatorio.model;

import java.io.Serializable;
import java.time.LocalDate;

public class Relatorio implements Serializable {
    private static final long serialVersionUID = 1L;

    private int id;
    private String nomePaciente;
    private String tipoExame;
    private LocalDate dataExame;
    private String resultado;
    private String observacao;

    public Relatorio() {
    }

    public Relatorio(String nomePaciente, String tipoExame, LocalDate dataExame, String resultado, String observacao) {
        this.nomePaciente = nomePaciente;
        this.tipoExame = tipoExame;
        this.dataExame = dataExame;
        this.resultado = resultado;
        this.observacao = observacao;
    }

    // Getters e setters
    public int getId() {
        return id;
    }
    public void setId(int id) {
        this.id = id;
    }
    public String getNomePaciente() {
        return nomePaciente;
    }
    public void setNomePaciente(String nomePaciente) {
        this.nomePaciente = nomePaciente;
    }
    public String getTipoExame() {
        return tipoExame;
    }
    public void setTipoExame(String tipoExame) {
        this.tipoExame = tipoExame;
    }
    public LocalDate getDataExame() {
        return dataExame;
    }
    public void setDataExame(LocalDate dataExame) {
        this.dataExame = dataExame;
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
        return "Relatorio{" +
                "id=" + id +
                ", nomePaciente='" + nomePaciente + '\'' +
                ", tipoExame='" + tipoExame + '\'' +
                ", dataExame=" + dataExame +
                ", resultado='" + resultado + '\'' +
                ", observacao='" + observacao + '\'' +
                '}';
    }
}

