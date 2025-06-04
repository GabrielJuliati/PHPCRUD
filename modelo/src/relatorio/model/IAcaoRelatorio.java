package relatorio.model;

public interface IAcaoRelatorio {
    void editar(Relatorio relatorio, String novoTipoExame, String novaDataExame);
    void excluir(Relatorio relatorio);
}
