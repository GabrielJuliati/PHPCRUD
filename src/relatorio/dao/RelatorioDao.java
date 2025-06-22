package relatorio.dao;

import java.util.List;
import java.util.ArrayList; // Importar se não estiver

import relatorio.model.Relatorio;
import relatorio.service.FileHandlerRelatorio;

public class RelatorioDao {
    private List<Relatorio> relatorios;
    private FileHandlerRelatorio fileHandler;

    public RelatorioDao() {
        fileHandler = new FileHandlerRelatorio();
        relatorios = fileHandler.carregarRelatorios(); // carregar ao iniciar
    }

    // NOVO MÉTODO: Obtém o próximo ID disponível lendo os IDs existentes no arquivo.
    // Torne-o estático para ser chamado diretamente pela View ou Controller
    public static int getProximoId() {
        // Criar uma instância temporária do FileHandler para carregar sem mudar o estado do DAO
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
        // Se o ID não foi gerado antes (ex: passou 0 no construtor), o DAO pode gerar
        // Se a View já passa um ID, isso não é estritamente necessário aqui, mas é uma boa prática
        // if (relatorio.getId() == 0) {
        //     relatorio.setId(getProximoId()); // Recomenda-se um setter de ID privado ou via construtor interno
        // }
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