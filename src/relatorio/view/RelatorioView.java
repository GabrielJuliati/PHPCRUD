package relatorio.view;

import java.util.List;
import java.util.Scanner;

import relatorio.controller.RelatorioController;
import relatorio.model.Paciente;
import relatorio.model.Relatorio;

/**
 * Camada de visualização (View) para o sistema de Relatórios.
 * Interage com o usuário e exibe informações.
 */
public class RelatorioView {

    private RelatorioController controller = new RelatorioController();
    private Scanner scanner = new Scanner(System.in);

    public RelatorioView() {
    }

    public void menu() {
        int opcao;
        do {
            System.out.println("\n=== Sistema de Relatórios ===");
            System.out.println("1 - Adicionar Relatório Manualmente");
            System.out.println("2 - Listar Relatórios");
            System.out.println("3 - Editar Relatório");
            System.out.println("4 - Excluir Relatório");
            System.out.println("5 - Gerar Relatórios Aleatórios");
            System.out.println("0 - Sair");
            System.out.print("Opção: ");
            opcao = scanner.nextInt();
            scanner.nextLine();

            switch (opcao) {
                case 1:
                    adicionarRelatorioManual();
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
                case 5:
                    gerarRelatoriosAleatorios();
                    break;
                case 0:
                    System.out.println("Saindo do sistema de relatórios...");
                    break;
                default:
                    System.out.println("Opção inválida! Por favor, tente novamente.");
            }
        } while (opcao != 0);
    }

    private void adicionarRelatorioManual() {
        System.out.println("\n--- Novo Relatório Manual ---");

        System.out.print("ID do Paciente (apenas números): ");
        int pacienteId = scanner.nextInt();
        scanner.nextLine();

        System.out.print("Nome do Paciente: ");
        String nomePaciente = scanner.nextLine();
        Paciente paciente = new Paciente(pacienteId, nomePaciente);

        System.out.print("CPF do Paciente (apenas números): ");
        String cpfPaciente = scanner.nextLine();

        System.out.print("Tipo do Exame: ");
        String tipoExame = scanner.nextLine();

        System.out.print("Data do Exame (dd/mm/aaaa): ");
        String dataExame = scanner.nextLine();

        System.out.print("Resultado (Positivado/Negativado/Em andamento): ");
        String resultado = scanner.nextLine();

        System.out.print("Observação (opcional): ");
        String observacao = scanner.nextLine();

        int idRelatorioGerado = relatorio.dao.RelatorioDao.getProximoId();
        Relatorio relatorio = new Relatorio(idRelatorioGerado, paciente, tipoExame, dataExame,
                                            cpfPaciente, resultado, observacao);

        controller.adicionarRelatorio(relatorio);
        System.out.println("Relatório adicionado com sucesso! ID: " + idRelatorioGerado);
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

        Relatorio relatorioExistente = controller.buscarPorId(id);
        if (relatorioExistente == null) {
            System.out.println("Relatório com ID " + id + " não encontrado.");
            return;
        }

        System.out.print("Novo tipo de exame (atual: " + relatorioExistente.getTipoExame() + "): ");
        String novoTipo = scanner.nextLine();

        System.out.print("Nova data do exame (dd/mm/aaaa, atual: " + relatorioExistente.getDataExame() + "): ");
        String novaData = scanner.nextLine();

        System.out.print("Novo resultado (Positivado/Negativado/Em andamento, atual: " + relatorioExistente.getResultado() + "): ");
        String novoResultado = scanner.nextLine();

        System.out.print("Nova observação (atual: " + (relatorioExistente.getObservacao() != null ? relatorioExistente.getObservacao() : "N/A") + "): ");
        String novaObservacao = scanner.nextLine();

        controller.editarRelatorio(id, novoTipo, novaData, novoResultado, novaObservacao);
        System.out.println("Relatório atualizado com sucesso!");
    }

    private void excluirRelatorio() {
        System.out.print("\nInforme o ID do relatório para excluir: ");
        int id = scanner.nextInt();
        scanner.nextLine();

        Relatorio relatorioParaExcluir = controller.buscarPorId(id);
        if (relatorioParaExcluir == null) {
            System.out.println("Relatório com ID " + id + " não encontrado.");
            return;
        }

        controller.excluirRelatorio(id);
        System.out.println("Relatório excluído com sucesso!");
    }

    private void gerarRelatoriosAleatorios() {
        System.out.print("\nQuantos relatórios aleatórios você deseja gerar? ");
        int quantidade = scanner.nextInt();
        scanner.nextLine();

        if (quantidade <= 0) {
            System.out.println("A quantidade deve ser um número positivo.");
            return;
        }

        controller.gerarRelatoriosAleatorios(quantidade);
    }

    public static void main(String[] args) {
        new RelatorioView().menu();
    }
}
