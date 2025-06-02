package controller;

import dao.ExameDAO;
import model.Exame;
import java.util.List;

public class ExameController {
    private ExameDAO exameDAO;

    public ExameController() {
        this.exameDAO = new ExameDAO();
    }

    public void cadastrarExame(String nomeExame, String descricao) {
        Exame exame = new Exame(0, nomeExame, descricao);
        exameDAO.salvar(exame);
        System.out.println("✅ Exame cadastrado com sucesso.");
    }

    public List<Exame> listarExames() {
        return exameDAO.listarTodos();
    }

    public Exame buscarExamePorId(int id) {
        return exameDAO.buscarPorId(id);
    }
}
