package controller;

import dao.AgendamentoDAO;
import model.Agendamento;

import java.time.LocalDateTime;
import java.util.List;

public class AgendamentoController {
    private AgendamentoDAO agendamentoDAO;

    public AgendamentoController() {
        this.agendamentoDAO = new AgendamentoDAO();
    }

    public void cadastrarAgendamento(String nome, LocalDateTime dataConsulta, String tipoExame) {
        Agendamento agendamento = new Agendamento(0, nome, dataConsulta, tipoExame);
        agendamentoDAO.salvar(agendamento);
        System.out.println("✅ Agendamento cadastrado com sucesso.");
    }

    public List<Agendamento> listarAgendamentos() {
        return agendamentoDAO.listarTodos();
    }

    public Agendamento buscarAgendamentoPorId(int id) {
        return agendamentoDAO.buscarPorId(id);
    }
}
