package relatorio.view;

import relatorio.model.Relatorio;
import relatorio.service.RelatorioService;

import java.time.LocalDate;
import java.time.format.DateTimeParseException;
import java.util.List;
import java.util.Scanner;

public class RelatorioView {
    private RelatorioService service = new RelatorioService();
    private Scanner scanner = new Scanner(System.in);

    public void menu() {
        int opcao = -1;

        while (opcao != 0) {
            System.out.println("\n=== Menu Relatórios ===");
            System.out.println("1 - Listar todos");
            System.out.println("2 - Adicionar");
            System.out.println("3 - Atualizar");
            System.out.println("4 - Excluir");
            System.out.println("0 - Sair");
            System.out.print("Escolha a opção: ");

            try {
                opcao = Integer.parseInt(scanner.nextLine());
            } catch (NumberFormatException e) {
                opcao = -1;
            }

            switch (opcao) {
                case 1 -> listarRelatorios();
                case 2 -> adicionarRelatorio();
                case 3 -> atualizarRelatorio();
                case 4 -> excluirRelatorio();
                case 0 -> System.out.println("Saindo...");
                default -> System.out.println("Opção inválida.");
            }
        }
    }

    private void listarRelatorios() {
        List<Relatorio> relatorios = service.obterTodos();
        if (relatorios.isEmpty()) {
            System.out.println("Nenhum relatório cadastrado.");
        } else {
            System.out.println("\nLista de relatórios:");
            for (Relatorio r : relatorios) {
                System.out.println(r);
            }
        }
    }

    private void adicionarRelatorio() {
        System.out.println("\n=== Novo Relatório ===");
        System.out.print("Nome do Paciente: ");
        String nome = scanner.nextLine();

        System.out.print("Tipo do Exame: ");
        String tipo = scanner.nextLine();

        LocalDate data = lerData();

        System.out.print("Resultado: ");
        String resultado = scanner.nextLine();

        System.out.print("Observação: ");
        String obs = scanner.nextLine();

        Relatorio r = new Relatorio(nome, tipo, data, resultado, obs);
        service.criarRelatorio(r);
        System.out.println("Relatório adicionado com sucesso!");
    }

    private void atualizarRelatorio() {
        System.out.print("\nInforme o ID do relatório para atualizar: ");
        int id = lerInteiro();

        Relatorio r = service.obterPorId(id);
        if (r == null) {
            System.out.println("Relatório não encontrado.");
            return;
        }

        System.out.println("Atualizando relatório: " + r);

        System.out.print("Nome do Paciente (" + r.getNomePaciente() + "): ");
        String nome = scanner.nextLine();
        if (!nome.isBlank()) r.setNomePaciente(nome);

        System.out.print("Tipo do Exame (" + r.getTipoExame() + "): ");
        String tipo = scanner.nextLine();
        if (!tipo.isBlank()) r.setTipoExame(tipo);

        System.out.print("Data do Exame (" + r.getDataExame() + ") (yyyy-MM-dd): ");
        String dataStr = scanner.nextLine();
        if (!dataStr.isBlank()) {
            try {
                LocalDate data = LocalDate.parse(dataStr);
                r.setDataExame(data);
            } catch (DateTimeParseException e) {
                System.out.println("Data inválida. Mantendo data anterior.");
            }
        }

        System.out.print("Resultado (" + r.getResultado() + "): ");
        String resultado = scanner.nextLine();
        if (!resultado.isBlank()) r.setResultado(resultado);

        System.out.print("Observação (" + r.getObservacao() + "): ");
        String obs = scanner.nextLine();
        if (!obs.isBlank()) r.setObservacao(obs);

        service.atualizarRelatorio(r);
        System.out.println("Relatório atualizado com sucesso!");
    }

    private void excluirRelatorio() {
        System.out.print("\nInforme o ID do relatório para excluir: ");
        int id = lerInteiro();

        Relatorio r = service.obterPorId(id);
        if (r == null) {
            System.out.println("Relatório não encontrado.");
            return;
        }

        service.deletarRelatorio(id);
        System.out.println("Relatório excluído com sucesso!");
    }

    private int lerInteiro() {
        while (true) {
            try {
                return Integer.parseInt(scanner.nextLine());
            } catch (NumberFormatException e) {
                System.out.print("Número inválido. Tente novamente: ");
            }
        }
    }

    private LocalDate lerData() {
        while (true) {
            System.out.print("Data do Exame (yyyy-MM-dd): ");
            String dataStr = scanner.nextLine();
            try {
                return LocalDate.parse(dataStr);
            } catch (DateTimeParseException e) {
                System.out.println("Data inválida, tente no formato yyyy-MM-dd.");
            }
        }
    }

    public static void main(String[] args) {
        RelatorioView view = new RelatorioView();
        view.menu();
    }
}
