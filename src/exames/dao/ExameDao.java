package dao;

import java.util.ArrayList;
import java.util.List;

import model.Exame;

public class ExameDAO {

    public void salvar(Exame exame) {
        if (exame.getId() == 0) {
            exame.setId(FileHandlerExame.getProximoId());
        }
        FileHandlerExame.escreverInsertExame(exame.getId(), exame.getNomeExame(), exame.getDescricao());
    }

    public List<Exame> listarTodos() {
        List<String> linhas = FileHandlerExame.lerLinhasExames();
        List<Exame> exames = new ArrayList<>();

        for (String linha : linhas) {
            if (linha.startsWith("INSERT INTO Exame")) {
                int id = Integer.parseInt(FileHandlerExame.getValorCampo(linha, "id"));
                String nome = FileHandlerExame.getValorCampo(linha, "nome_exame");
                String descricao = FileHandlerExame.getValorCampo(linha, "descricao");

                exames.add(new Exame(id, nome, descricao));
            }
        }

        return exames;
    }

    public Exame buscarPorId(int idBuscado) {
        List<Exame> exames = listarTodos();
        for (Exame exame : exames) {
            if (exame.getId() == idBuscado) {
                return exame;
            }
        }
        return null;
    }
}
