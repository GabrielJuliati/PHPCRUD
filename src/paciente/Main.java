package paciente;

import java.sql.Date;
import java.time.LocalDate;
import java.util.Random;

import File.FileSql;

public class Main {
    public static void main(String[] args) {
        int quantidade = 200;

        FileSql fileSql = new FileSql();

        for (int i = 0; i < quantidade; i++) {
            Paciente paciente = new Paciente();

            String nome = gerarNomeAleatorio();
            Date dataNascimento = gerarDataNascimentoAleatoria();
            String endereco = gerarEnderecoAleatorio();
            String telefone = gerarTelefoneAleatorio();
            String cpf = gerarCPFAleatorio();
            String obs = gerarObservacaoAleatoria();

            paciente.setNome(nome);
            paciente.setDataNascimento(dataNascimento);
            paciente.setEndereco(endereco);
            paciente.setTelefone(telefone);
            paciente.setCpf(cpf);
            paciente.setObs(obs);

            String insert = paciente.insert();
            fileSql.writeInsertStatement(insert);
        }

        System.out.println("Arquivo SQL com pacientes gerado com sucesso!");
    }

    private static String gerarNomeAleatorio() {
        String[] nomes = {"Ana", "Bruno", "Carlos", "Daniela", "Eduardo", "Fernanda", "Gabriel", "Helena", "Igor", "Juliana"};
        String[] sobrenomes = {"Silva", "Souza", "Oliveira", "Pereira", "Almeida", "Costa", "Lima", "Martins", "Gomes", "Ribeiro"};

        Random random = new Random();
        String nome = nomes[random.nextInt(nomes.length)];
        String sobrenome = sobrenomes[random.nextInt(sobrenomes.length)];

        return nome + " " + sobrenome;
    }

    private static Date gerarDataNascimentoAleatoria() {
        Random random = new Random();
        int minYear = 1940;
        int maxYear = 2020;

        int year = minYear + random.nextInt(maxYear - minYear + 1);
        int month = 1 + random.nextInt(12);
        int day = 1 + random.nextInt(28);

        LocalDate localDate = LocalDate.of(year, month, day);
        return Date.valueOf(localDate);
    }

    private static String gerarEnderecoAleatorio() {
        String[] ruas = {"Rua das Flores", "Avenida Brasil", "Travessa da Paz", "Rua São João", "Alameda Santos"};
        int numero = 1 + new Random().nextInt(1000);
        return ruas[new Random().nextInt(ruas.length)] + ", " + numero;
    }

    private static String gerarTelefoneAleatorio() {
        Random random = new Random();
        int ddd = 11 + random.nextInt(9);
        int num1 = 1000 + random.nextInt(9000);
        int num2 = 1000 + random.nextInt(9000);

        return String.format("(%d) %d-%d", ddd, num1, num2);
    }

    private static String gerarCPFAleatorio() {
        Random random = new Random();
        StringBuilder cpf = new StringBuilder();

        for (int i = 0; i < 11; i++) {
            cpf.append(random.nextInt(10));
        }

        return cpf.toString();
    }

    private static String gerarObservacaoAleatoria() {
        String[] observacoes = {
            "Paciente sem alergias.",
            "Histórico de hipertensão.",
            "Nenhuma observação relevante.",
            "Alérgico a penicilina.",
            "Paciente em acompanhamento."
        };
        return observacoes[new Random().nextInt(observacoes.length)];
    }
}