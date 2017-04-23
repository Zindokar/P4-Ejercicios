package textprocessing;

import com.sun.javafx.collections.MappingChange;

import java.util.HashMap;
import java.util.Map;

public class FileProcessor extends Thread {
    private WordFrequencies wordFrequencies;
    private FileContents fileContents;
    
    public FileProcessor(FileContents fc, WordFrequencies wf) {
        fileContents = fc;
        wordFrequencies = wf;
    }

    public void run() {
        String fileContent = fileContents.getContents();
        while (fileContent != null) {
            fileContent =  fileContents.getContents();
            if (fileContent == null || fileContent.isEmpty()) {
                continue;
            }
            String [] words = fileContent.split("\\s+"); // corto las palabras por un espacio o más
            Map<String, Integer> frequencies = new HashMap<String, Integer>();
            for (String word : words) {
                frequencies.put(word, frequencies.containsKey(word) ? frequencies.get(word) + 1 : 1);
            }
            wordFrequencies.addFrequencies(frequencies);
        }
    }
}
