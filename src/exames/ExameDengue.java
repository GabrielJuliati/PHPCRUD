import java.util.Date;

public class ExameDengue {
    private Long id;
    private Long agendamentoId;
    private Long pacienteId;
    private String nome;
    private Boolean amostraSangue;
    private Date dataInicioSintomas;

    public Date dataConsulta;
    public String pacienteNome;
    public String pacienteCpf;
    public String tipoExame;

    public ExameDengue() {}

    // Getters & Setters
    public Long getId() { return id; }
    public void setId(Long id) { this.id = id; }
    
    public Long getAgendamentoId() { return agendamentoId; }
    public void setAgendamentoId(Long agendamentoId) { this.agendamentoId = agendamentoId; }
    
    public Long getPacienteId() { return pacienteId; }
    public void setPacienteId(Long pacienteId) { this.pacienteId = pacienteId; }
    
    public String getNome() { return nome; }
    public void setNome(String nome) { this.nome = nome; }
    
    public Boolean getAmostraSangue() { return amostraSangue; }
    public void setAmostraSangue(Boolean amostraSangue) { this.amostraSangue = amostraSangue; }
    
    public Date getDataInicioSintomas() { return dataInicioSintomas; }
    public void setDataInicioSintomas(Date dataInicioSintomas) { this.dataInicioSintomas = dataInicioSintomas; }
}