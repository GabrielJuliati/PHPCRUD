package relatorio.model;

/**
 * Representa um Paciente.
 */
public class Paciente {
    private int id;
    private String nome;

    public Paciente(int id, String nome) {
        this.id = id;
        this.nome = nome;
    }

    public int getId() {
        return id;
    }

    public String getNome() {
        return nome;
    }

    public void setNome(String nome) {
        this.nome = nome;
    }
}
