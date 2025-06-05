package File;

import java.io.*;

public class FileSql {
    private static String fileName = "arquivo.sql";

    public void writeInsertStatement(String insert) {
        try {
            FileWriter fw = new FileWriter(fileName, true);
            PrintWriter pw = new PrintWriter(fw);
            pw.println(insert);
            pw.close();	
        }catch (IOException e) {
            System.err.println("Error: " + e.getMessage());
        }
    }
}
