package usuario;

public class Usuario {
    private int id;
    private String name;
    private String emailInstitucional;
    private String password;
    private String rol;

    public int getId() {
        return id;
    }
    public void setId(int id) {
        this.id = id;
    }
    public String getName() {
        return name;
    }
    public void setName(String name) {
        this.name = name;
    }
    public String getEmailInstitucional() {
        return emailInstitucional;
    }
    public void setEmailInstitucional(String emailInstitucional) {
        this.emailInstitucional = emailInstitucional;
    }
    public String getPassword() {
        return password;
    }
    public void setPassword(String password) {
        this.password = password;
    }
    public String getRol() {
        return rol;
    }
    public void setRol(String rol) {
        this.rol = rol;
    }

    public String insert() {
        return "INSERT INTO usuario (nome, email, senha, rol) VALUES ('" + name + "', '" + emailInstitucional + "', '" + password + "', '" + rol + "'); \n";
    }
    
}