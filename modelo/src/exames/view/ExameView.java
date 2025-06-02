package view;

import controller.ExameController;
import model.Exame;

import java.util.List;
import java.util.Scanner;

public class ExameView {
    private ExameController controller;
    private Scanner scanner;

    public ExameView() {
        this.controller = new ExameController();
        this.scanner = new Scanner(System.in);
    }

    public void exibirMenuExames() {
        int opcao;
        do {
            System.out.println("\n--- MENU DE EXAMES ---");
            System.out.println("1. Cadastrar Novo Exame");
            System.out.println("2. Listar Todos os Exames");
            System.out.println("3. Buscar Exame por ID");
            System.out.println("0. Voltar ao Menu Principal");
            System.out.print("Escolha uma opção: ");

            try {
                opcao = Integer.parseInt(scanner.nextLine());
            } catch (NumberFormatException e) {
                opcao = -1;
            }

            switch (opcao) {
                case 1:
                    cadastrarExame();
                    break;
                case 2:
                    listarExames();
                    break;
                case 3:
                    buscarExamePorId();
                    break;
                case 0:
                    System.out.println("Retornando ao menu principal...");
                    break;
                default:
                    System.out.println("Opção inválida. Tente novamente.");
            }
        } while (opcao != 0);
    }

    private void cadastrarExame() {
        System.out.println("\n--- Cadastrar Novo Exame ---");
        System.out.print("Nome do Exame: ");
        String nome = scanner.nextLine();
        System.out.print("Descrição do Exame: ");
        String descricao = scanner.nextLine();

        controller.cadastrarExame(nome, descricao);
    }

    private void listarExames() {
        System.out.println("\n--- Lista de Exames ---");
        List<Exame> exames = controller.listarExames();
        if (exames.isEmpty()) {
            System.out.println("Nenhum exame cadastrado.");
        } else {
            for (Exame e : exames) {
                System.out.println("ID: " + e.getId() + " | Nome: " + e.getNomeExame() + " | Descrição: " + e.getDescricao());
            }
        }
    }

    private void buscarExamePorId() {
        System.out.println("\n--- Buscar Exame por ID ---");
        System.out.print("Digite o ID do Exame: ");
        try {
            int id = Integer.parseInt(scanner.nextLine());
            Exame exame = controller.buscarExamePorId(id);
            if (exame != null) {
                System.out.println("Exame Encontrado:");
                System.out.println("ID: " + exame.getId());
                System.out.println("Nome: " + exame.getNomeExame());
                System.out.println("Descrição: " + exame.getDescricao());
            } else {
                System.out.println("Nenhum exame encontrado com esse ID.");
            }
        } catch (NumberFormatException e) {
            System.out.println("ID inválido.");
        }
    }
}
