import controller.ExameController;
import view.ExameView;

public class AppExame {
    public static void main(String[] args) {
        ExameController controller = new ExameController();
        ExameView menu = new ExameView(controller);
        menu.exibirMenuExames();
    }
}