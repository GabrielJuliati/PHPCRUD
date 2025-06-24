import java.util.Date;

public class ExameABO {
    private Long id;
    private Long agendamentoId;
    private Long pacienteId;
    private String nome;
    private Boolean amostraDna;
    private String tipoSanguineo;
    private String observacoes;

    public Date dataConsulta;
    public String pacienteNome;
    public String pacienteCpf;
    public String tipoExame;

    public ExameABO() {}

    // Getters & Setters
    public Long getId() { return id; }
    public void setId(Long id) { this.id = id; }
    
    public Long getAgendamentoId() { return agendamentoId; }
    public void setAgendamentoId(Long agendamentoId) { this.agendamentoId = agendamentoId; }
    
    public Long getPacienteId() { return pacienteId; }
    public void setPacienteId(Long pacienteId) { this.pacienteId = pacienteId; }
    
    public String getNome() { return nome; }
    public void setNome(String nome) { this.nome = nome; }
    
    public Boolean getAmostraDna() { return amostraDna; }
    public void setAmostraDna(Boolean amostraDna) { this.amostraDna = amostraDna; }
    
    public String getTipoSanguineo() { return tipoSanguineo; }
    public void setTipoSanguineo(String tipoSanguineo) { this.tipoSanguineo = tipoSanguineo; }
    
    public String getObservacoes() { return observacoes; }
    public void setObservacoes(String observacoes) { this.observacoes = observacoes; }
}