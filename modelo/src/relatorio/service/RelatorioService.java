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

    public void editar(Relatorio relatorio, String novoTipoExame, String novaDataExame) {
        if (relatorio != null) {
            relatorio.setTipoExame(novoTipoExame);
            relatorio.setDataExame(novaDataExame);
            relatorioDao.atualizar(relatorio); // isso já salva no arquivo
        }
    }

    public void excluir(Relatorio relatorio) {
        relatorioDao.excluir(relatorio); // também salva no arquivo
    }
}
