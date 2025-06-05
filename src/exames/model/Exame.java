public class Exame {
    private int id;
    private String nomeExame;
    private String descricao;

    public Exame() {
    }

    public Exame(int id, String nomeExame, String descricao) {
        this.id = id;
        this.nomeExame = nomeExame;
        this.descricao = descricao;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getNomeExame() {
        return nomeExame;
    }

    public void setNomeExame(String nomeExame) {
        this.nomeExame = nomeExame;
    }

    public String getDescricao() {
        return descricao;
    }

    public void setDescricao(String descricao) {
        this.descricao = descricao;
    }

    @Override
    public String toString() {
        return "Exame [id=" + id + ", nomeExame=" + nomeExame + ", descricao=" + descricao + "]";
    }
}
