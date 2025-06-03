package relatorio.controller;

import relatorio.model.Relatorio;
import relatorio.service.RelatorioService;

import java.time.LocalDate;
import java.util.List;

public class RelatorioController {
    private RelatorioService service = new RelatorioService();

    public void executar() {
        // Criar relatório
        Relatorio r1 = new Relatorio("Lucas", "Sangue", LocalDate.now(), "Negativo", "Sem observações");
        service.criarRelatorio(r1);

        // Listar todos
        List<Relatorio> relatorios = service.obterTodos();
        relatorios.forEach(System.out::println);

        // Atualizar relatório
        r1.setResultado("Positivo");
        service.atualizarRelatorio(r1);

        // Buscar por id
        Relatorio r2 = service.obterPorId(r1.getId());
        System.out.println("Após atualização: " + r2);

        // Excluir
        service.deletarRelatorio(r1.getId());

        System.out.println("Após exclusão, lista:");
        service.obterTodos().forEach(System.out::println);
    }

    public static void main(String[] args) {
        new RelatorioController().executar();
    }
}
