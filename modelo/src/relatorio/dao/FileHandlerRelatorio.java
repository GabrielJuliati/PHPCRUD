package relatorio.dao;

import relatorio.model.Relatorio;

import java.io.*;
import java.util.ArrayList;
import java.util.List;

public class FileHandlerRelatorio {
    private static final String FILE_PATH = "relatorios.dat";

    public static void salvar(List<Relatorio> relatorios) {
        try (ObjectOutputStream oos = new ObjectOutputStream(new FileOutputStream(FILE_PATH))) {
            oos.writeObject(relatorios);
        } catch (IOException e) {
            System.err.println("Erro ao salvar relatórios: " + e.getMessage());
        }
    }

    public static List<Relatorio> carregar() {
        File file = new File(FILE_PATH);
        if (!file.exists()) {
            return new ArrayList<>();
        }

        try (ObjectInputStream ois = new ObjectInputStream(new FileInputStream(FILE_PATH))) {
            return (List<Relatorio>) ois.readObject();
        } catch (IOException | ClassNotFoundException e) {
            System.err.println("Erro ao carregar relatórios: " + e.getMessage());
            return new ArrayList<>();
        }
    }
}


