package relatorio.controller;

import java.util.List;

import relatorio.model.Relatorio;
import relatorio.service.RelatorioService;
import relatorio.dao.RelatorioDao;

/**
 * Controlador para operações relacionadas a Relatórios.
 * Gerencia a interação entre a View e o Serviço.
 */
public class RelatorioController {
    private RelatorioService service;

    public RelatorioController() {
        this.service = new RelatorioService(new RelatorioDao());
    }

    public void adicionarRelatorio(Relatorio relatorio) {
        service.adicionar(relatorio);
    }

    public List<Relatorio> listarRelatorios() {
        return service.listar();
    }

    public Relatorio buscarPorId(int id) {
        return service.buscarPorId(id);
    }

    public void editarRelatorio(int id, String novoTipoExame, String novaDataExame, String novoResultado, String novaObservacao) {
        Relatorio relatorio = service.buscarPorId(id);
        service.editar(relatorio, novoTipoExame, novaDataExame, novoResultado, novaObservacao);
    }

    public void excluirRelatorio(int id) {
        Relatorio relatorio = service.buscarPorId(id);
        service.excluir(relatorio);
    }

    /**
     * Inicia o processo de geração de relatórios aleatórios.
     */
    public void gerarRelatoriosAleatorios(int quantidade) {
        service.gerarRelatoriosAleatorios(quantidade);
    }
}
