package relatorio.service;

import relatorio.dao.RelatorioDao;
import relatorio.model.Relatorio;

import java.util.List;

public class RelatorioService {
    private RelatorioDao dao = new RelatorioDao();

    public List<Relatorio> obterTodos() {
        return dao.listarTodos();
    }

    public Relatorio obterPorId(int id) {
        return dao.buscarPorId(id);
    }

    public void criarRelatorio(Relatorio relatorio) {
        dao.adicionar(relatorio);
    }

    public void atualizarRelatorio(Relatorio relatorio) {
        dao.atualizar(relatorio);
    }

    public void deletarRelatorio(int id) {
        dao.excluir(id);
    }
}
