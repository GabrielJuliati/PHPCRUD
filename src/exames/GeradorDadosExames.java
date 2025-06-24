import java.io.FileWriter;
import java.io.IOException;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.Arrays;
import java.util.Collections;
import java.util.List;
import java.util.Random;

public class GeradorDadosExames {
    private static final Random random = new Random();
    private static final List<String> TIPOS_SANGUINEOS = Arrays.asList("A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-");
    private static final List<String> SINTOMAS_COVID = Arrays.asList("Febre", "Tosse", "Cansaço", "Perda de Paladar", "Falta de Ar");
    private static final String[] NOMES = {
        "Ana", "Bruno", "Carlos", "Daniela", "Eduardo", "Fernanda", "Gabriel", 
        "Helena", "Igor", "Juliana", "Lucas", "Mariana", "Natalia", "Otavio", 
        "Patricia", "Rafael", "Sandra", "Thiago", "Vanessa", "Wagner"
    };
    private static final String[] SOBRENOMES = {
        "Silva", "Souza", "Oliveira", "Pereira", "Almeida", "Costa", "Lima", 
        "Martins", "Gomes", "Ribeiro", "Carvalho", "Ferreira", "Rodrigues", 
        "Alves", "Santos", "Barbosa", "Dias", "Moreira", "Cardoso", "Campos"
    };

    public static void main(String[] args) {
        int quantidade = 200;
        String nomeArquivo = "exames.sql";
        
        try (FileWriter writer = new FileWriter(nomeArquivo)) {
            writer.write("-- Script SQL para inserção de exames\n");
            writer.write("INSERT INTO exame (id, agendamento_id, paciente_id, paciente_nome, paciente_cpf, tipo_exame, data_consulta, data_inicio_sintomas, amostra_sangue, amostra_dna, tipo_sanguineo, tipo_teste, status_amostra, resultado, sintomas, observacoes) VALUES\n");
            
            for (int i = 0; i < quantidade; i++) {
                String insert = gerarInsertExameAleatorio(i + 1, i == quantidade - 1);
                writer.write(insert);
            }
            
            System.out.println("Arquivo SQL gerado com sucesso: " + nomeArquivo);
            System.out.println("Total de exames gerados: " + quantidade);
            
        } catch (IOException e) {
            System.err.println("Erro ao gerar arquivo: " + e.getMessage());
        }
    }

    private static String gerarInsertExameAleatorio(int id, boolean ultimo) {
        int tipoExame = random.nextInt(3); // 0: Dengue, 1: ABO, 2: COVID
        long agendamentoId = random.nextLong(1000);
        long pacienteId = 1000 + random.nextInt(9000);
        String pacienteNome = gerarNomeAleatorio();
        String pacienteCpf = gerarCPFAleatorio();
        String tipoExameStr = tipoExame == 0 ? "Dengue" : tipoExame == 1 ? "ABO" : "COVID";
        LocalDateTime dataConsulta = gerarDataConsultaAleatoria();
        LocalDateTime dataInicioSintomas = gerarDataInicioSintomasAleatoria();
        DateTimeFormatter formatter = DateTimeFormatter.ofPattern("yyyy-MM-dd HH:mm:ss");
        
        StringBuilder insert = new StringBuilder();
        insert.append(String.format("(%d, %d, %d, '%s', '%s', '%s', '%s'",
            id, agendamentoId, pacienteId, pacienteNome.replace("'", "''"), pacienteCpf, tipoExameStr, dataConsulta.format(formatter)));
        
        if (tipoExame == 0) { // Dengue
            boolean amostraSangue = random.nextBoolean();
            insert.append(String.format(", '%s', %b, NULL, NULL, NULL, NULL, NULL, NULL",
                dataInicioSintomas.format(formatter), amostraSangue));
        } else if (tipoExame == 1) { // ABO
            boolean amostraDna = random.nextBoolean();
            String tipoSanguineo = TIPOS_SANGUINEOS.get(random.nextInt(TIPOS_SANGUINEOS.size()));
            String observacoes = "Observação " + random.nextInt(10);
            insert.append(String.format(", NULL, NULL, %b, '%s', NULL, NULL, NULL, '%s'",
                amostraDna, tipoSanguineo, observacoes.replace("'", "''")));
        } else { // COVID
            String tipoTeste = random.nextBoolean() ? "RT-PCR" : "Antígeno";
            String statusAmostra = random.nextBoolean() ? "Válida" : "Inválida";
            String resultado = random.nextBoolean() ? "Positivo" : "Negativo";
            List<String> sintomas = gerarSintomasAleatorios();
            String observacoes = "Observação " + random.nextInt(10);
            insert.append(String.format(", '%s', NULL, NULL, NULL, '%s', '%s', '%s', '%s'",
                dataInicioSintomas.format(formatter), tipoTeste, statusAmostra, resultado, sintomas.toString().replace("'", "''"), observacoes.replace("'", "''")));
        }
        
        return ultimo ? insert + ";\n" : insert + ",\n";
    }

    private static String gerarNomeAleatorio() {
        String nome = NOMES[random.nextInt(NOMES.length)];
        String sobrenome = SOBRENOMES[random.nextInt(SOBRENOMES.length)];
        return nome + " " + sobrenome;
    }

    private static String gerarCPFAleatorio() {
        StringBuilder cpf = new StringBuilder();
        for (int i = 0; i < 11; i++) {
            cpf.append(random.nextInt(10));
        }
        return cpf.toString();
    }

    private static LocalDateTime gerarDataConsultaAleatoria() {
        LocalDateTime hoje = LocalDateTime.now();
        int dias = 1 + random.nextInt(90); // Próximos 90 dias
        int horas = random.nextInt(14) + 8; // Entre 8h e 21h
        int minutos = random.nextInt(4) * 15; // Em intervalos de 15 minutos
        
        return hoje.plusDays(dias)
                   .withHour(horas)
                   .withMinute(minutos)
                   .withSecond(0);
    }

    private static LocalDateTime gerarDataInicioSintomasAleatoria() {
        LocalDateTime hoje = LocalDateTime.now();
        int diasAtras = random.nextInt(30); // Até 30 dias atrás
        return hoje.minusDays(diasAtras)
                   .withHour(0)
                   .withMinute(0)
                   .withSecond(0);
    }

    private static List<String> gerarSintomasAleatorios() {
        Collections.shuffle(SINTOMAS_COVID);
        return SINTOMAS_COVID.subList(0, random.nextInt(SINTOMAS_COVID.size()) + 1);
    }
}