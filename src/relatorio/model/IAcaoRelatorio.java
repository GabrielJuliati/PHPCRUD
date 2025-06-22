package relatorio.model;

public interface IAcaoRelatorio {
    // Atualiza o método editar para incluir os novos campos
    void editar(Relatorio relatorio, String novoTipoExame, String novaDataExame, String novoResultado, String novaObservacao);
    void excluir(Relatorio relatorio);
}