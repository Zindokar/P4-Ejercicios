package textprocessing;
public class FileProcessor extends Thread {
    WordFrequencies wordFrequencies;
    FileContents fileContents;
    
    public FileProcessor(FileContents fc, WordFrequencies wf) {
        fileContents = fc;
        wordFrequencies = wf;
    }

    public void run() {
        String content = fileContents.getContents();
        System.out.println("YEEKA: " + (content == null ? "null":content));
    }
}
