package relatorio.dao;

import java.util.List;

import relatorio.model.Relatorio;
import relatorio.service.FileHandlerRelatorio;

public class RelatorioDao {
    private List<Relatorio> relatorios;
    private FileHandlerRelatorio fileHandler;

    public RelatorioDao() {
        fileHandler = new FileHandlerRelatorio();
        relatorios = fileHandler.carregarRelatorios(); // carregar ao iniciar
    }

    public void adicionar(Relatorio relatorio) {
        relatorios.add(relatorio);
        fileHandler.salvarRelatorios(relatorios);
    }

    public List<Relatorio> listarTodos() {
        return relatorios;
    }

    public Relatorio buscarPorId(int id) {
        for (Relatorio r : relatorios) {
            if (r.getId() == id) {
                return r;
            }
        }
        return null;
    }

    public void atualizar(Relatorio relatorioAtualizado) {
        for (int i = 0; i < relatorios.size(); i++) {
            if (relatorios.get(i).getId() == relatorioAtualizado.getId()) {
                relatorios.set(i, relatorioAtualizado);
                break;
            }
        }
        fileHandler.salvarRelatorios(relatorios);
    }

    public void excluir(Relatorio relatorio) {
        relatorios.remove(relatorio);
        fileHandler.salvarRelatorios(relatorios);
    }
}
