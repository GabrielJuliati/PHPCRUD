import java.util.Date;
import java.util.List;

public class ExameCovid {
    private Long id;
    private Long agendamentoId;
    private Long pacienteId;
    private String nome;
    private String tipoTeste;
    private String statusAmostra;
    private String resultado;
    private Date dataInicioSintomas;
    private List<String> sintomas;
    private String observacoes;

    public Date dataConsulta;
    public String pacienteNome;
    public String pacienteCpf;
    public String tipoExame;

    public ExameCovid() {}

    // Getters & Setters
    public Long getId() { return id; }
    public void setId(Long id) { this.id = id; }
    
    public Long getAgendamentoId() { return agendamentoId; }
    public void setAgendamentoId(Long agendamentoId) { this.agendamentoId = agendamentoId; }
    
    public Long getPacienteId() { return pacienteId; }
    public void setPacienteId(Long pacienteId) { this.pacienteId = pacienteId; }
    
    public String getNome() { return nome; }
    public void setNome(String nome) { this.nome = nome; }
    
    public String getTipoTeste() { return tipoTeste; }
    public void setTipoTeste(String tipoTeste) { this.tipoTeste = tipoTeste; }
    
    public String getStatusAmostra() { return statusAmostra; }
    public void setStatusAmostra(String statusAmostra) { this.statusAmostra = statusAmostra; }
    
    public String getResultado() { return resultado; }
    public void setResultado(String resultado) { this.resultado = resultado; }
    
    public Date getDataInicioSintomas() { return dataInicioSintomas; }
    public void setDataInicioSintomas(Date dataInicioSintomas) { this.dataInicioSintomas = dataInicioSintomas; }
    
    public List<String> getSintomas() { return sintomas; }
    public void setSintomas(List<String> sintomas) { this.sintomas = sintomas; }
    
    public String getObservacoes() { return observacoes; }
    public void setObservacoes(String observacoes) { this.observacoes = observacoes; }
}