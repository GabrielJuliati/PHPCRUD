import controller.AgendamentoController;
import view.AgendamentoView;

public class AppAgendamento {
    public static void main(String[] args) {
        AgendamentoController controller = new AgendamentoController();
        AgendamentoView menu = new AgendamentoView(controller);
        menu.exibirMenuAgendamentos();
    }
}