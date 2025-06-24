package relatorio.service;

import relatorio.model.Paciente;
import relatorio.model.Relatorio;
import java.io.*;
import java.util.ArrayList;
import java.util.List;

/**
 * Classe utilitária para lidar com a leitura e escrita de objetos Relatorio
 * em arquivos de texto e na geração de scripts SQL.
 */
public class FileHandlerRelatorio {

    private static final String FILE_NAME = "relatorios.txt";
    private static final String SQL_FILE_NAME = "relatorios_inserts.sql";

    /**
     * Salva uma lista de relatórios no arquivo de texto e também gera os comandos INSERT SQL.
     */
    public void salvarRelatorios(List<Relatorio> relatorios) {
        try (BufferedWriter bw = new BufferedWriter(new FileWriter(FILE_NAME))) {
            for (Relatorio r : relatorios) {
                // Formato de salvamento: id|pacienteId|pacienteNome|cpfPaciente|tipoExame|dataExame|resultado|observacao
                bw.write(r.getId() + "|" +
                         r.getPaciente().getId() + "|" +
                         r.getPaciente().getNome() + "|" +
                         r.getCpfPaciente() + "|" +
                         r.getTipoExame() + "|" +
                         r.getDataExame() + "|" +
                         r.getResultado() + "|" +
                         r.getObservacao());
                bw.newLine();

                escreverInsertRelatorioSQL(r);
            }
        } catch (IOException e) {
            System.out.println("Erro ao salvar arquivo: " + e.getMessage());
        }
    }

    /**
     * Escreve um comando INSERT SQL para um único relatório no arquivo .sql.
     */
    private void escreverInsertRelatorioSQL(Relatorio relatorio) {
        String observacaoEscapada = relatorio.getObservacao() != null ?
                                    relatorio.getObservacao().replace("'", "''") : "";

        String nomePacienteEscapado = relatorio.getPaciente().getNome() != null ?
                                      relatorio.getPaciente().getNome().replace("'", "''") : "";

        // Formato INSERT INTO para a tabela 'relatorios' (MySQL)
        String insertSQL = String.format(
            "INSERT INTO `relatorios` (`id`, `nome_paciente`, `tipo_exame`, `data_exame`, `resultado`, `observacao`, `cpf`) " +
            "VALUES (%d, '%s', '%s', '%s', '%s', '%s', '%s');",
            relatorio.getId(),
            nomePacienteEscapado,
            relatorio.getTipoExame(),
            relatorio.getDataExame(),
            relatorio.getResultado(),
            observacaoEscapada,
            relatorio.getCpfPaciente()
        );

        try (FileWriter fw = new FileWriter(SQL_FILE_NAME, true);
             PrintWriter pw = new PrintWriter(fw)) {
            pw.println(insertSQL);
        } catch (IOException e) {
            System.err.println("Erro ao escrever no arquivo SQL: " + e.getMessage());
        }
    }

    /**
     * Carrega a lista de relatórios de um arquivo de texto.
     */
    public List<Relatorio> carregarRelatorios() {
        List<Relatorio> relatorios = new ArrayList<>();
        File file = new File(FILE_NAME);
        if (!file.exists()) {
            return relatorios;
        }

        try (BufferedReader br = new BufferedReader(new FileReader(FILE_NAME))) {
            String linha;
            while ((linha = br.readLine()) != null) {
                String[] partes = linha.split("\\|");
                // Tamanho esperado: 8 campos
                if (partes.length == 8) {
                    try {
                        int id = Integer.parseInt(partes[0]);
                        int pacienteId = Integer.parseInt(partes[1]);
                        String pacienteNome = partes[2];
                        String cpfPaciente = partes[3];
                        String tipoExame = partes[4];
                        String dataExame = partes[5];
                        String resultado = partes[6];
                        String observacao = partes[7];

                        Paciente paciente = new Paciente(pacienteId, pacienteNome);
                        Relatorio relatorio = new Relatorio(id, paciente, tipoExame, dataExame,
                                                            cpfPaciente, resultado, observacao);
                        relatorios.add(relatorio);
                    } catch (NumberFormatException e) {
                        System.err.println("Erro de formato numérico ao carregar linha: " + linha + " - " + e.getMessage());
                    }
                } else {
                    System.err.println("Linha mal formatada no arquivo " + FILE_NAME + ": " + linha);
                }
            }
        } catch (IOException e) {
            System.out.println("Erro ao carregar arquivo: " + e.getMessage());
        }

        return relatorios;
    }
}
