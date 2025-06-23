package relatorio.service;

import relatorio.model.Paciente;
import relatorio.model.Relatorio;
import java.io.*;
import java.util.ArrayList;
import java.util.List;

public class FileHandlerRelatorio {

    private static final String FILE_NAME = "relatorios.txt";
    private static final String SQL_FILE_NAME = "relatorios_inserts.sql"; // NOVO: Nome do arquivo SQL

    public void salvarRelatorios(List<Relatorio> relatorios) {
        try (BufferedWriter bw = new BufferedWriter(new FileWriter(FILE_NAME))) {
            for (Relatorio r : relatorios) {
                // Formato atualizado para incluir CPF, Resultado e Observação
                // id|pacienteId|pacienteNome|cpfPaciente|tipoExame|dataExame|resultado|observacao
                bw.write(r.getId() + "|" +
                         r.getPaciente().getId() + "|" +
                         r.getPaciente().getNome() + "|" +
                         r.getCpfPaciente() + "|" +
                         r.getTipoExame() + "|" +
                         r.getDataExame() + "|" +
                         r.getResultado() + "|" +
                         r.getObservacao());
                bw.newLine();
                
                // NOVO: Escrever também no arquivo SQL a cada adição
                escreverInsertRelatorioSQL(r); 
            }
        } catch (IOException e) {
            System.out.println("Erro ao salvar arquivo: " + e.getMessage());
        }
    }

    // NOVO MÉTODO: Escreve um comando INSERT SQL no arquivo .sql
    private void escreverInsertRelatorioSQL(Relatorio relatorio) {
        // Prepare a string de observação para SQL (substitui aspas simples por duas aspas simples para escapar)
        String observacaoEscapada = relatorio.getObservacao() != null ? 
                                    relatorio.getObservacao().replace("'", "''") : "";

        // Formato INSERT INTO correspondente à sua tabela MySQL 'relatorios'
        // id, nome_paciente, tipo_exame, data_exame, resultado, observacao, cpf
        String insertSQL = String.format(
            "INSERT INTO `relatorios` (`id`, `nome_paciente`, `tipo_exame`, `data_exame`, `resultado`, `observacao`, `cpf`) " +
            "VALUES (%d, '%s', '%s', '%s', '%s', '%s', '%s');", // '%s' para strings, %d para int
            relatorio.getId(),
            relatorio.getPaciente().getNome(),
            relatorio.getTipoExame(),
            relatorio.getDataExame(), // Assumindo dd/mm/yyyy. Pode precisar converter para yyyy-mm-dd
            relatorio.getResultado(),
            observacaoEscapada,
            relatorio.getCpfPaciente()
        );

        try (FileWriter fw = new FileWriter(SQL_FILE_NAME, true); // 'true' para adicionar ao final do arquivo
             PrintWriter pw = new PrintWriter(fw)) {
            pw.println(insertSQL);
        } catch (IOException e) {
            System.err.println("Erro ao escrever no arquivo SQL: " + e.getMessage());
        }
    }

    public List<Relatorio> carregarRelatorios() {
        List<Relatorio> relatorios = new ArrayList<>();
        File file = new File(FILE_NAME);
        if (!file.exists()) {
            return relatorios; // arquivo não existe ainda
        }

        try (BufferedReader br = new BufferedReader(new FileReader(FILE_NAME))) {
            String linha;
            while ((linha = br.readLine()) != null) {
                String[] partes = linha.split("\\|");
                // O tamanho esperado agora é 8 (id, pacienteId, pacienteNome, cpfPaciente, tipoExame, dataExame, resultado, observacao)
                if (partes.length == 8) {
                    int id = Integer.parseInt(partes[0]);
                    int pacienteId = Integer.parseInt(partes[1]);
                    String pacienteNome = partes[2];
                    String cpfPaciente = partes[3];    
                    String tipoExame = partes[4];
                    String dataExame = partes[5];
                    String resultado = partes[6];      
                    String observacao = partes[7];     

                    Paciente paciente = new Paciente(pacienteId, pacienteNome);
                    // Construtor atualizado para o modelo Relatorio
                    Relatorio relatorio = new Relatorio(id, paciente, tipoExame, dataExame,
                                                        cpfPaciente, resultado, observacao); 
                    relatorios.add(relatorio);
                } else {
                    System.err.println("Linha mal formatada no arquivo " + FILE_NAME + ": " + linha);
                }
            }
        } catch (IOException | NumberFormatException e) { 
            System.out.println("Erro ao carregar arquivo: " + e.getMessage());
        }

        return relatorios;
    }

    // Este método é chamado pelo RelatorioDao.getProximoId()
    public static int getProximoId() {
        // Criar uma instância temporária do FileHandler para carregar sem mudar o estado do DAO
        FileHandlerRelatorio tempFileHandler = new FileHandlerRelatorio();
        List<Relatorio> relatoriosExistentes = tempFileHandler.carregarRelatorios();
        int maxId = 0;
        for (Relatorio r : relatoriosExistentes) {
            if (r.getId() > maxId) {
                maxId = r.getId();
            }
        }
        return maxId + 1;
    }
}