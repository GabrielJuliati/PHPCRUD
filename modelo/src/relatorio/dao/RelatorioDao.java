package relatorio.dao;

import relatorio.model.Relatorio;

import java.util.ArrayList;
import java.util.List;

public class RelatorioDao {
    private List<Relatorio> relatorios;
    private int contadorId;

    public RelatorioDao() {
        this.relatorios = FileHandlerRelatorio.carregar();
        this.contadorId = calcularUltimoId() + 1;
    }

    private int calcularUltimoId() {
        int maxId = 0;
        for (Relatorio r : relatorios) {
            if (r.getId() > maxId) {
                maxId = r.getId();
            }
        }
        return maxId;
    }

    public List<Relatorio> listarTodos() {
        return new ArrayList<>(relatorios);
    }

    public Relatorio buscarPorId(int id) {
        for (Relatorio r : relatorios) {
            if (r.getId() == id) {
                return r;
            }
        }
        return null;
    }

    public void adicionar(Relatorio relatorio) {
        relatorio.setId(contadorId++);
        relatorios.add(relatorio);
        FileHandlerRelatorio.salvar(relatorios);
    }

    public void atualizar(Relatorio relatorioAtualizado) {
        Relatorio relatorio = buscarPorId(relatorioAtualizado.getId());
        if (relatorio != null) {
            relatorio.setNomePaciente(relatorioAtualizado.getNomePaciente());
            relatorio.setTipoExame(relatorioAtualizado.getTipoExame());
            relatorio.setDataExame(relatorioAtualizado.getDataExame());
            relatorio.setResultado(relatorioAtualizado.getResultado());
            relatorio.setObservacao(relatorioAtualizado.getObservacao());
            FileHandlerRelatorio.salvar(relatorios);
        }
    }

    public void excluir(int id) {
        relatorios.removeIf(r -> r.getId() == id);
        FileHandlerRelatorio.salvar(relatorios);
    }
}
