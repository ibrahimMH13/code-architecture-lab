import string;
from collections import Counter



def count_words(fileName):

    with open(fileName,"r",encoding="utf-8") as f:
       txt = f.read()
    translator = txt.maketrans('','',string.punctuation)
    cleand_txt = txt.translate(translator).lower() 
    words = cleand_txt.split()
    word_counts = Counter(words)
    total = len(word_counts)    
    print(f"Total words: {word_counts}")
    print(f"\nUnique word counts:{total}")
    for word, count in word_counts.most_common():
        print(f"{word}: {count}")

if __name__ == "__main__":
    filename = input("Enter the path to your .txt file: ")
    count_words(filename)
