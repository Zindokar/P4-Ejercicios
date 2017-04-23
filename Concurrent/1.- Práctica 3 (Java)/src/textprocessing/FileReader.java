package textprocessing;
public class FileReader extends Thread {
    private FileNames fileNames;
    private FileContents fileContents;
    
    public FileReader(FileNames fn, FileContents fc) {
        fileNames = fn;
        fileContents = fc;
    }
    
    public void run() {
        String fileName = fileNames.getName();
        while (fileName != null) {
            fileContents.registerWriter();
            fileContents.addContents(Tools.getContents(fileName));
            fileContents.unregisterWriter();
            fileName = fileNames.getName();
        }
    }
}
