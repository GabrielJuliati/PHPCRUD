package relatorio.controller;

import java.util.List;

import relatorio.model.Relatorio;
import relatorio.service.RelatorioService;
import relatorio.dao.RelatorioDao; // <--- DESCOMENTE OU ADICIONE ESTA LINHA!

public class RelatorioController {
    private RelatorioService service;

    public RelatorioController() {
        // Agora, RelatorioDao será resolvido corretamente
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
}