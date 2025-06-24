import java.io.FileWriter;
import java.io.IOException;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.Random;

public class AgendamentoGenerator {
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
    
    private static final String[] TIPOS_EXAME = {
        "Dengue", "ABO", "COVID-19"
    };
    
    private static final Random random = new Random();

    public static void main(String[] args) {
        int quantidade = 200;
        String nomeArquivo = "agendamentos.sql";
        
        try (FileWriter writer = new FileWriter(nomeArquivo)) {
            writer.write("-- Script SQL para inserção de agendamentos\n");
            writer.write("INSERT INTO agendamento (paciente_id, data_consulta, tipo_exame) VALUES\n");
            
            for (int i = 0; i < quantidade; i++) {
                Agendamento agendamento = gerarAgendamentoAleatorio(i + 1);
                String insert = formatarInsert(agendamento, i == quantidade - 1);
                writer.write(insert);
            }
            
            System.out.println("Arquivo SQL gerado com sucesso: " + nomeArquivo);
            System.out.println("Total de agendamentos gerados: " + quantidade);
            
        } catch (IOException e) {
            System.err.println("Erro ao gerar arquivo: " + e.getMessage());
        }
    }

    public static Agendamento gerarAgendamentoAleatorio(int id) {
        // Gerar dados do paciente
        String pacienteNome = gerarNomeAleatorio();
        String pacienteCpf = gerarCPFAleatorio();
        int pacienteId = 1000 + random.nextInt(9000); // IDs entre 1000 e 9999
        
        // Gerar data de consulta (próximos 90 dias)
        LocalDateTime dataConsulta = gerarDataConsultaAleatoria();
        
        // Selecionar tipo de exame
        String tipoExame = TIPOS_EXAME[random.nextInt(TIPOS_EXAME.length)];
        
        return new Agendamento(id, dataConsulta, pacienteId, pacienteNome, pacienteCpf, tipoExame);
    }

    private static String formatarInsert(Agendamento agendamento, boolean ultimo) {
        DateTimeFormatter formatter = DateTimeFormatter.ofPattern("yyyy-MM-dd HH:mm:ss");
        String dataFormatada = agendamento.getDataConsulta().format(formatter);
        
        String insert = String.format(
            "(%d, '%s', '%s')",
            agendamento.getPacienteId(),
            dataFormatada,
            agendamento.getTipoExame().replace("'", "''")
        );
        
        return ultimo ? insert + ";" : insert + ",\n";
    }

    private static String gerarNomeAleatorio() {
        String nome = NOMES[random.nextInt(NOMES.length)];
        String sobrenome = SOBRENOMES[random.nextInt(SOBRENOMES.length)];
        return nome + " " + sobrenome;
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

    private static String gerarCPFAleatorio() {
        StringBuilder cpf = new StringBuilder();
        for (int i = 0; i < 11; i++) {
            cpf.append(random.nextInt(10));
        }
        return cpf.toString();
    }
}