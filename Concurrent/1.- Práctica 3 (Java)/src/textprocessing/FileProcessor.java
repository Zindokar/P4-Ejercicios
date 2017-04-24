package textprocessing;

import java.util.HashMap;
import java.util.Map;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

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
            wordFrequencies.addFrequencies(getFrequenciesByString(fileContent));
            fileContent = fileContents.getContents();
        }
    }

    private Map<String, Integer> getFrequenciesByString(String content) {
        Map<String, Integer> frequencies = new HashMap<>();

        Pattern pattern = Pattern.compile("\\b[A-z0-9]+\\b");
        Matcher matcher = pattern.matcher(content);

        while (matcher.find()) {
            String word = matcher.group();
            frequencies.put(word, frequencies.containsKey(word) ? frequencies.get(word) + 1 : 1);
        }

        return frequencies;
    }
}
