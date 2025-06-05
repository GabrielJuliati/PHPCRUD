package relatorio.view;

import java.util.List;
import java.util.Scanner;

import relatorio.controller.RelatorioController;
import relatorio.model.Paciente;
import relatorio.model.Relatorio;

public class RelatorioView {

    private RelatorioController controller = new RelatorioController();
    private Scanner scanner = new Scanner(System.in);
    private int idRelatorio = 1;
    private int idPaciente = 1;

    public void menu() {
        int opcao;
        do {
            System.out.println("\n=== Sistema de Relatórios ===");
            System.out.println("1 - Adicionar Relatório");
            System.out.println("2 - Listar Relatórios");
            System.out.println("3 - Editar Relatório");
            System.out.println("4 - Excluir Relatório");
            System.out.println("0 - Sair");
            System.out.print("Opção: ");
            opcao = scanner.nextInt();
            scanner.nextLine(); // consumir \n

            switch (opcao) {
                case 1:
                    adicionarRelatorio();
                    break;
                case 2:
                    listarRelatorios();
                    break;
                case 3:
                    editarRelatorio();
                    break;
                case 4:
                    excluirRelatorio();
                    break;
                case 0:
                    System.out.println("Saindo...");
                    break;
                default:
                    System.out.println("Opção inválida!");
            }
        } while (opcao != 0);
    }

    private void adicionarRelatorio() {
        System.out.println("\n--- Novo Relatório ---");
        System.out.print("Nome do Paciente: ");
        String nomePaciente = scanner.nextLine();
        Paciente paciente = new Paciente(idPaciente++, nomePaciente);

        System.out.print("Tipo do Exame: ");
        String tipoExame = scanner.nextLine();

        System.out.print("Data do Exame (dd/mm/aaaa): ");
        String dataExame = scanner.nextLine();

        Relatorio relatorio = new Relatorio(idRelatorio++, paciente, tipoExame, dataExame);
        controller.adicionarRelatorio(relatorio);

        System.out.println("Relatório adicionado com sucesso!");
    }

    private void listarRelatorios() {
        System.out.println("\n--- Lista de Relatórios ---");
        List<Relatorio> relatorios = controller.listarRelatorios();

        if (relatorios.isEmpty()) {
            System.out.println("Nenhum relatório cadastrado.");
        } else {
            for (Relatorio r : relatorios) {
                System.out.println(r.toString());
            }
        }
    }

    private void editarRelatorio() {
        System.out.print("\nInforme o ID do relatório para editar: ");
        int id = scanner.nextInt();
        scanner.nextLine();

        System.out.print("Novo tipo de exame: ");
        String novoTipo = scanner.nextLine();

        System.out.print("Nova data do exame (dd/mm/aaaa): ");
        String novaData = scanner.nextLine();

        controller.editarRelatorio(id, novoTipo, novaData);
        System.out.println("Relatório atualizado.");
    }

    private void excluirRelatorio() {
        System.out.print("\nInforme o ID do relatório para excluir: ");
        int id = scanner.nextInt();
        scanner.nextLine();

        controller.excluirRelatorio(id);
        System.out.println("Relatório excluído.");
    }

    public static void main(String[] args) {
        new RelatorioView().menu();
    }
}
