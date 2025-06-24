package relatorio.dao;

import java.util.List;
import java.util.ArrayList;

import relatorio.model.Relatorio;
import relatorio.service.FileHandlerRelatorio;

/**
 * Objeto de Acesso a Dados (DAO) para Relatórios.
 * Gerencia a persistência dos objetos Relatorio em arquivo.
 */
public class RelatorioDao {
    private List<Relatorio> relatorios;
    private FileHandlerRelatorio fileHandler;

    public RelatorioDao() {
        fileHandler = new FileHandlerRelatorio();
        relatorios = fileHandler.carregarRelatorios();
    }

    /**
     * Obtém o próximo ID disponível para um novo relatório.
     * Garante IDs sequenciais e únicos.
     */
    public static int getProximoId() {
        FileHandlerRelatorio tempFileHandler = new FileHandlerRelatorio();
        List<Relatorio> relatoriosExistentes = tempFileHandler.carregarRelatorios();
        int maxId = 0;
        for (Relatorio r : relatoriosExistentes) {
            if (r.getId() > maxId) {
                maxId = r.getId();
            }
        }
        return maxId + 1;
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
