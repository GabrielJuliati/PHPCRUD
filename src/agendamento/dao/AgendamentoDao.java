package dao;

import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.ArrayList;
import java.util.List;

import model.Agendamento;

public class AgendamentoDao {

    private static final DateTimeFormatter FORMATTER = DateTimeFormatter.ofPattern("yyyy-MM-dd HH:mm");

    public void salvar(Agendamento agendamento) {
        if (agendamento.getId() == 0) {
            agendamento.setId(FileHandlerAgendamento.getProximoId());
        }

        String dataConsultaFormatada = agendamento.getDataConsulta().format(FORMATTER);
        FileHandlerAgendamento.escreverInsertAgendamento(
            agendamento.getId(),
            agendamento.getNome(),
            dataConsultaFormatada,
            agendamento.getTipoExame()
        );
    }

    public List<Agendamento> listarTodos() {
        List<String> linhas = FileHandlerAgendamento.lerLinhasAgendamentos();
        List<Agendamento> agendamentos = new ArrayList<>();

        for (String linha : linhas) {
            if (linha.startsWith("INSERT INTO agendamento")) {
                try {
                    int id = Integer.parseInt(FileHandlerAgendamento.getValorCampo(linha, "id"));
                    String nome = FileHandlerAgendamento.getValorCampo(linha, "nome");
                    String dataStr = FileHandlerAgendamento.getValorCampo(linha, "data_consulta");
                    String tipo = FileHandlerAgendamento.getValorCampo(linha, "tipo_exame");

                    LocalDateTime dataConsulta = LocalDateTime.parse(dataStr, FORMATTER);
                    agendamentos.add(new Agendamento(id, nome, dataConsulta, tipo));
                } catch (Exception e) {
                    System.err.println("Erro ao processar linha de agendamento: " + e.getMessage());
                }
            }
        }

        return agendamentos;
    }

    public Agendamento buscarPorId(int idBuscado) {
        for (Agendamento agendamento : listarTodos()) {
            if (agendamento.getId() == idBuscado) {
                return agendamento;
            }
        }
        return null;
    }
}
