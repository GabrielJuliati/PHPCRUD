package relatorio.service;

import relatorio.dao.RelatorioDao;
import relatorio.model.Relatorio;

import java.util.List;

public class RelatorioService {
    private RelatorioDao relatorioDao;

    public RelatorioService(RelatorioDao relatorioDao) {
        this.relatorioDao = relatorioDao;
    }

    public void adicionar(Relatorio relatorio) {
        relatorioDao.adicionar(relatorio);
    }

    public List<Relatorio> listar() {
        return relatorioDao.listarTodos();
    }

    public Relatorio buscarPorId(int id) {
        return relatorioDao.buscarPorId(id);
    }

    // Método editar atualizado para incluir os novos campos
    public void editar(Relatorio relatorio, String novoTipoExame, String novaDataExame, String novoResultado, String novaObservacao) {
        if (relatorio != null) {
            relatorio.setTipoExame(novoTipoExame);
            relatorio.setDataExame(novaDataExame);
            relatorio.setResultado(novoResultado);   // NOVO: Define o novo resultado
            relatorio.setObservacao(novaObservacao); // NOVO: Define a nova observação
            relatorioDao.atualizar(relatorio);
        }
    }

    public void excluir(Relatorio relatorio) {
        relatorioDao.excluir(relatorio);
    }
}