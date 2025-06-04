package usuario;

import java.util.Random;

import File.FileSql;

public class Main {
    public static void main(String[] args) {
        int quantidade = 110;

        FileSql fileSql = new FileSql();
        Random random = new Random();

        for (int i = 0; i < quantidade; i++) {
            Usuario user = new Usuario();

            String nome = gerarNomeAleatorio();
            String email = gerarEmailAleatorio(nome);
            String senha = gerarSenhaAleatoria();
            String rol = random.nextBoolean() ? "DEFAULT" : "ADM";

            user.setName(nome);
            user.setEmailInstitucional(email);
            user.setPassword(senha);
            user.setRol(rol);

            String insert = user.insert();
            fileSql.writeInsertStatement(insert);
        }

        System.out.println("Arquivo SQL gerado com sucesso!");
    }

    private static String gerarNomeAleatorio() {
        String[] nomes = {"Ana", "Bruno", "Carlos", "Daniela", "Eduardo", "Fernanda", "Gabriel", "Helena", "Igor", "Juliana"};
        String[] sobrenomes = {"Silva", "Souza", "Oliveira", "Pereira", "Almeida", "Costa", "Lima", "Martins", "Gomes", "Ribeiro"};

        Random random = new Random();
        String nome = nomes[random.nextInt(nomes.length)];
        String sobrenome = sobrenomes[random.nextInt(sobrenomes.length)];

        return nome + " " + sobrenome;
    }

    private static String gerarEmailAleatorio(String nome) {
        String[] dominios = {"@gmail.com", "@hotmail.com", "@outlook.com", "@sps.com"};
        Random random = new Random();

        String email = nome.toLowerCase().replace(" ", ".") + random.nextInt(1000) + dominios[random.nextInt(dominios.length)];
        return email;
    }

    private static String gerarSenhaAleatoria() {
        String caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        StringBuilder senha = new StringBuilder();
        Random random = new Random();

        int tamanho = 8 + random.nextInt(5);

        for (int i = 0; i < tamanho; i++) {
            senha.append(caracteres.charAt(random.nextInt(caracteres.length())));
        }

        return senha.toString();
    }
}