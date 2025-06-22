package relatorio.view;

import java.util.List;
import java.util.Scanner;

import relatorio.controller.RelatorioController;
import relatorio.model.Paciente;
import relatorio.model.Relatorio;

public class RelatorioView {

    private RelatorioController controller = new RelatorioController();
    private Scanner scanner = new Scanner(System.in);
    private int proximoIdRelatorio;
    private int proximoIdPaciente;

    public RelatorioView() {
        this.proximoIdRelatorio = relatorio.dao.RelatorioDao.getProximoId(); // Garante ID sequencial ao iniciar
        this.proximoIdPaciente = 1; 
    }

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
        Paciente paciente = new Paciente(proximoIdPaciente++, nomePaciente);

        System.out.print("CPF do Paciente (apenas números): ");
        String cpfPaciente = scanner.nextLine();

        System.out.print("Tipo do Exame: ");
        String tipoExame = scanner.nextLine();

        System.out.print("Data do Exame (dd/mm/aaaa): ");
        String dataExame = scanner.nextLine();

        // Alterado o prompt para incluir "Em andamento"
        System.out.print("Resultado (Positivado/Negativado/Em andamento): "); 
        String resultado = scanner.nextLine();

        System.out.print("Observação (opcional): ");
        String observacao = scanner.nextLine();

        int idRelatorioGerado = relatorio.dao.RelatorioDao.getProximoId(); // Chama o método para obter o próximo ID
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
        
        // Alterado o prompt para incluir "Em andamento"
        System.out.print("Novo resultado (Positivado/Negativado/Em andamento, atual: " + relatorioExistente.getResultado() + "): ");
        String novoResultado = scanner.nextLine();
        
        System.out.print("Nova observação (atual: " + (relatorioExistente.getObservacao() != null ? relatorioExistente.getObservacao() : "N/A") + "): ");
        String novaObservacao = scanner.nextLine();

        controller.editarRelatorio(id, novoTipo, novaData, novoResultado, novaObservacao);
        System.out.println("Relatório atualizado.");
    }

    private void excluirRelatorio() {
        System.out.print("\nInforme o ID do relatório para excluir: ");
        int id = scanner.nextInt();
        scanner.nextLine();

        controller.excluirRelatorio(id);
        System.out.println("Relatório excluído.");
    }

    private int getProximoIdRelatorio() {
        // Agora, o ID é obtido do DAO, que sabe a sequência a partir do arquivo
        return relatorio.dao.RelatorioDao.getProximoId(); 
    }

    private int getProximoIdPaciente() {
        return proximoIdPaciente++;
    }

    public static void main(String[] args) {
        new RelatorioView().menu();
    }
}