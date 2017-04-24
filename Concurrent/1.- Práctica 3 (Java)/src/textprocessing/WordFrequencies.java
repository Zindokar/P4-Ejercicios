package textprocessing;

import java.util.Map;
import java.util.HashMap;

public class WordFrequencies {

    private Map<String,Integer> frequencies;

    public WordFrequencies() {
        frequencies = new HashMap<>();
    }

    public synchronized void addFrequencies(Map<String,Integer> f) {
        for (Map.Entry<String, Integer> each : f.entrySet()) {
            String word = each.getKey();
            frequencies.put(word, frequencies.containsKey(word) ? frequencies.get(word) + each.getValue() : each.getValue());
        }
    }
    
    public Map<String,Integer> getFrequencies() {
        return frequencies;
    }
}
