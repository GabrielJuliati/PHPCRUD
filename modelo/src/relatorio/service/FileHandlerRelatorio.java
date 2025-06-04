package relatorio.service;

import relatorio.model.Paciente;
import relatorio.model.Relatorio;
import java.io.*;
import java.util.ArrayList;
import java.util.List;

public class FileHandlerRelatorio {

    private static final String FILE_NAME = "relatorios.txt";

    public void salvarRelatorios(List<Relatorio> relatorios) {
        try (BufferedWriter bw = new BufferedWriter(new FileWriter(FILE_NAME))) {
            for (Relatorio r : relatorios) {
                // salvar no formato: id|pacienteId|pacienteNome|tipoExame|dataExame
                bw.write(r.getId() + "|" + r.getPaciente().getId() + "|" + r.getPaciente().getNome() + "|" +
                        r.getTipoExame() + "|" + r.getDataExame());
                bw.newLine();
            }
        } catch (IOException e) {
            System.out.println("Erro ao salvar arquivo: " + e.getMessage());
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
                if (partes.length == 5) {
                    int id = Integer.parseInt(partes[0]);
                    int pacienteId = Integer.parseInt(partes[1]);
                    String pacienteNome = partes[2];
                    String tipoExame = partes[3];
                    String dataExame = partes[4];

                    Paciente paciente = new Paciente(pacienteId, pacienteNome);
                    Relatorio relatorio = new Relatorio(id, paciente, tipoExame, dataExame);
                    relatorios.add(relatorio);
                }
            }
        } catch (IOException e) {
            System.out.println("Erro ao carregar arquivo: " + e.getMessage());
        }

        return relatorios;
    }
}
