package view;

import controller.AgendamentoController;
import model.Agendamento;

import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.List;
import java.util.Scanner;

public class AgendamentoView {
    private AgendamentoController controller;
    private Scanner scanner;
    private DateTimeFormatter formatter = DateTimeFormatter.ofPattern("dd/MM/yyyy HH:mm");

    public AgendamentoView() {
        this.controller = new AgendamentoController();
        this.scanner = new Scanner(System.in);
    }

    public void exibirMenuAgendamentos() {
        int opcao;
        do {
            System.out.println("\n--- MENU DE AGENDAMENTOS ---");
            System.out.println("1. Cadastrar Novo Agendamento");
            System.out.println("2. Listar Todos os Agendamentos");
            System.out.println("3. Buscar Agendamento por ID");
            System.out.println("0. Voltar ao Menu Principal");
            System.out.print("Escolha uma opção: ");

            try {
                opcao = Integer.parseInt(scanner.nextLine());
            } catch (NumberFormatException e) {
                opcao = -1;
            }

            switch (opcao) {
                case 1:
                    cadastrarAgendamento();
                    break;
                case 2:
                    listarAgendamentos();
                    break;
                case 3:
                    buscarAgendamentoPorId();
                    break;
                case 0:
                    System.out.println("Retornando ao menu principal...");
                    break;
                default:
                    System.out.println("Opção inválida. Tente novamente.");
            }
        } while (opcao != 0);
    }

    private void cadastrarAgendamento() {
        System.out.println("\n--- Cadastrar Novo Agendamento ---");
        System.out.print("Nome do Paciente: ");
        String nome = scanner.nextLine();

        System.out.print("Data e Hora da Consulta (formato: dd/MM/yyyy HH:mm): ");
        LocalDateTime dataConsulta;
        try {
            dataConsulta = LocalDateTime.parse(scanner.nextLine(), formatter);
        } catch (Exception e) {
            System.out.println("❌ Data inválida. Use o formato correto.");
            return;
        }

        System.out.print("Tipo de Exame: ");
        String tipoExame = scanner.nextLine();

        controller.cadastrarAgendamento(nome, dataConsulta, tipoExame);
    }

    private void listarAgendamentos() {
        System.out.println("\n--- Lista de Agendamentos ---");
        List<Agendamento> agendamentos = controller.listarAgendamentos();
        if (agendamentos.isEmpty()) {
            System.out.println("Nenhum agendamento cadastrado.");
        } else {
            for (Agendamento a : agendamentos) {
                System.out.println("ID: " + a.getId() +
                                   " | Nome: " + a.getNome() +
                                   " | Data: " + a.getDataConsulta().format(formatter) +
                                   " | Tipo de Exame: " + a.getTipoExame());
            }
        }
    }

    private void buscarAgendamentoPorId() {
        System.out.println("\n--- Buscar Agendamento por ID ---");
        System.out.print("Digite o ID do Agendamento: ");
        try {
            int id = Integer.parseInt(scanner.nextLine());
            Agendamento agendamento = controller.buscarAgendamentoPorId(id);
            if (agendamento != null) {
                System.out.println("Agendamento Encontrado:");
                System.out.println("ID: " + agendamento.getId());
                System.out.println("Nome: " + agendamento.getNome());
                System.out.println("Data da Consulta: " + agendamento.getDataConsulta().format(formatter));
                System.out.println("Tipo de Exame: " + agendamento.getTipoExame());
            } else {
                System.out.println("Nenhum agendamento encontrado com esse ID.");
            }
        } catch (NumberFormatException e) {
            System.out.println("ID inválido.");
        }
    }
}
