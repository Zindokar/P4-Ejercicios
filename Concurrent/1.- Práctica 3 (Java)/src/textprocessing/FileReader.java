package textprocessing;

public class FileReader extends Thread {
    private FileNames fileNames;
    private FileContents fileContents;
    
    public FileReader(FileNames fn, FileContents fc) {
        fileNames = fn;
        fileContents = fc;
    }
    
    public void run() {
        fileContents.registerWriter();
        String fileName = fileNames.getName();
        while (fileName != null) {
            fileContents.addContents(Tools.getContents(fileName));
            fileContents.unregisterWriter();
            fileContents.registerWriter();
            fileName = fileNames.getName();
        }
        fileContents.unregisterWriter();
    }
}
