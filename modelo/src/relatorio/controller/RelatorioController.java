package relatorio.controller;

import java.util.List;

import relatorio.model.Relatorio;
import relatorio.service.RelatorioService;
import relatorio.dao.RelatorioDao;

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

    public void editarRelatorio(int id, String novoTipoExame, String novaDataExame) {
        Relatorio relatorio = service.buscarPorId(id);
        service.editar(relatorio, novoTipoExame, novaDataExame);
    }

    public void excluirRelatorio(int id) {
        Relatorio relatorio = service.buscarPorId(id);
        service.excluir(relatorio);
    }
}
