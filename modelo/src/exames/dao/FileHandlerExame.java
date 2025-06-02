package dao;

import java.io.*;
import java.nio.file.*;
import java.util.*;

public class FileHandlerExame {
    private static final String FILE_NAME = "inserts.sql";

    public static synchronized void escreverInsertExame(int id, String nomeExame, String descricao) {
        String insert = String.format(
            "INSERT INTO exames (id, nome_exame, descricao) VALUES (%d, '%s', '%s');",
            id, nomeExame, descricao
        );
        try (FileWriter fw = new FileWriter(FILE_NAME, true);
             PrintWriter pw = new PrintWriter(fw)) {
            pw.println(insert);
        } catch (IOException e) {
            System.err.println("Erro ao escrever no arquivo: " + e.getMessage());
        }
    }

    public static synchronized List<String> lerLinhasExames() {
        try {
            if (!Files.exists(Paths.get(FILE_NAME))) return new ArrayList<>();
            return Files.readAllLines(Paths.get(FILE_NAME));
        } catch (IOException e) {
            System.err.println("Erro ao ler o arquivo: " + e.getMessage());
            return new ArrayList<>();
        }
    }

    public static String getValorCampo(String linha, String campo) {
        if (!linha.startsWith("INSERT INTO exames")) return null;

        try {
            String valores = linha.substring(linha.indexOf("VALUES (") + 8, linha.lastIndexOf(")"));
            String[] partes = valores.split(",\\s*");

            switch (campo) {
                case "id":
                    return partes[0].trim();
                case "nome_exame":
                    return partes[1].trim().replace("'", "");
                case "descricao":
                    return partes[2].trim().replace("'", "");
            }
        } catch (Exception e) {
            System.err.println("Erro ao extrair campo '" + campo + "' da linha: " + e.getMessage());
        }

        return null;
    }

    public static int getProximoId() {
        List<String> linhas = lerLinhasExames();
        int maxId = 0;

        for (String linha : linhas) {
            if (linha.startsWith("INSERT INTO e xames")) {
                try {
                    String valores = linha.substring(linha.indexOf("VALUES (") + 8, linha.lastIndexOf(")"));
                    String[] partes = valores.split(",\\s*");
                    int id = Integer.parseInt(partes[0].trim());
                    if (id > maxId) maxId = id;
                } catch (Exception e) {
                    System.err.println("Erro ao obter ID da linha: " + e.getMessage());
                }
            }
        }

        return maxId + 1;
    }
}
