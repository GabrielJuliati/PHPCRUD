package relatorio.service;

import relatorio.dao.RelatorioDao;
import relatorio.model.Paciente;
import relatorio.model.Relatorio;

import java.time.LocalDate;
import java.time.format.DateTimeFormatter;
import java.util.List;
import java.util.Random;

/**
 * Classe de serviço para gerenciar as operações de negócio dos Relatórios.
 * Inclui a lógica para adicionar, listar, buscar, editar, excluir e gerar relatórios aleatórios.
 */
public class RelatorioService {
    private RelatorioDao relatorioDao;
    private static final Random random = new Random();

    // Dados para geração aleatória
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

    private static final String[] RESULTADOS = {
        "Positivado", "Negativado", "Em andamento"
    };

    private static final String[] OBSERVACOES = {
        "Paciente estável.", "Recomenda-se acompanhamento.", "Exame inconclusivo.",
        "Aguardando contraprova.", "Necessário repetir o exame.", ""
    };

    public RelatorioService(RelatorioDao relatorioDao) {
        this.relatorioDao = relatorioDao;
    }

    public void adicionar(Relatorio relatorio) {
        relatorioDao.adicionar(relatorio);
    }

    public List<Relatorio> listar() {
        return relatorioDao.listarTodos();
    }

    public Relatorio buscarPorId(int id) {
        return relatorioDao.buscarPorId(id);
    }

    public void editar(Relatorio relatorio, String novoTipoExame, String novaDataExame, String novoResultado, String novaObservacao) {
        if (relatorio != null) {
            relatorio.setTipoExame(novoTipoExame);
            relatorio.setDataExame(novaDataExame);
            relatorio.setResultado(novoResultado);
            relatorio.setObservacao(novaObservacao);
            relatorioDao.atualizar(relatorio);
        }
    }

    public void excluir(Relatorio relatorio) {
        relatorioDao.excluir(relatorio);
    }

    /**
     * Gera um número especificado de relatórios aleatórios e os adiciona ao sistema.
     */
    public void gerarRelatoriosAleatorios(int quantidade) {
        System.out.println("Gerando " + quantidade + " relatórios aleatórios...");
        for (int i = 0; i < quantidade; i++) {
            int idRelatorio = relatorio.dao.RelatorioDao.getProximoId();

            String nomePaciente = gerarNomeAleatorio();
            // ID de paciente temporário para esta simulação.
            Paciente paciente = new Paciente(idRelatorio + 1000, nomePaciente);

            String cpfPaciente = gerarCPFAleatorio();
            String tipoExame = TIPOS_EXAME[random.nextInt(TIPOS_EXAME.length)];
            String dataExame = gerarDataExameAleatoria();
            String resultado = RESULTADOS[random.nextInt(RESULTADOS.length)];
            String observacao = OBSERVACOES[random.nextInt(OBSERVACOES.length)];

            Relatorio relatorio = new Relatorio(idRelatorio, paciente, tipoExame, dataExame,
                                                cpfPaciente, resultado, observacao);
            this.adicionar(relatorio);
        }
        System.out.println(quantidade + " relatórios aleatórios gerados e salvos com sucesso.");
    }

    private String gerarNomeAleatorio() {
        String nome = NOMES[random.nextInt(NOMES.length)];
        String sobrenome = SOBRENOMES[random.nextInt(SOBRENOMES.length)];
        return nome + " " + sobrenome;
    }

    private String gerarCPFAleatorio() {
        StringBuilder cpf = new StringBuilder();
        for (int i = 0; i < 11; i++) {
            cpf.append(random.nextInt(10));
        }
        return cpf.toString();
    }

    private String gerarDataExameAleatoria() {
        LocalDate hoje = LocalDate.now();
        int diasAtras = random.nextInt(365);
        LocalDate dataExame = hoje.minusDays(diasAtras);
        return dataExame.format(DateTimeFormatter.ofPattern("dd/MM/yyyy"));
    }
}
