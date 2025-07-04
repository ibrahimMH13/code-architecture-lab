<?php




    interface Command {

        public function execute();
    }

    interface ICommandEditor extends Command{

        public function undo();
    }


    class TextEditor{

        protected string $content = "";

        public function write(?string $txt){

            $this->content .= $txt;

        }

        public function erease(int $steps = 1){

            $this->content = substr($this->content,0,-$steps);

        }

        public function getContent():string {

            return $this->content;

        }
    }

    class WriteTextCommand implements ICommandEditor{

        public function __construct(protected TextEditor $tEditor, protected ?string $txt){}

        public function execute(){

            $this->tEditor->write($this->txt);
        }

        public function undo(){
            $this->tEditor->erease(strlen($this->txt));
        }
        
    }

    class EditorInvoker {

    protected array $redoStack = [];
    protected array $history = [];

    public function executeCommand(Command $command){

        $command->execute();
        $this->history[] = $command;
        $this->redoStack = [];
    }

     public function undo(){
        $command = array_pop($this->history);
        if($command){
          $command->undo();
          $this->redoStack[] = $command;
        }
      
     }

     public function redo(){
        $command = array_pop($this->redoStack);
        if($command){
            $command->execute();
            $this->history[] = $command;
        }
     }
    }

    $editor = new TextEditor();
    $invoker = new EditorInvoker();

    $invoker->executeCommand(new WriteTextCommand($editor, "Hello "));
    $invoker->executeCommand(new WriteTextCommand($editor, "Hello "));
    $invoker->executeCommand(new WriteTextCommand($editor, "Hello "));
    $invoker->executeCommand(new WriteTextCommand($editor, "Hello "));
    $invoker->executeCommand(new WriteTextCommand($editor, "World"));

    echo $editor->getContent() . "\n";

    $invoker->undo();
   
    echo $editor->getContent() . "\n";

    $invoker->redo();
    $invoker->redo();
    $invoker->redo();
    $invoker->redo();
    $invoker->redo();
    $invoker->redo();
    $invoker->redo();
    $invoker->redo();
    $invoker->redo();
    $invoker->redo();
    echo "starting undo";
    $invoker->undo();
    $invoker->undo();
    $invoker->undo();
    $invoker->undo();
    $invoker->undo();
    $invoker->undo();
    $invoker->undo();
    $invoker->undo();
    $invoker->undo();
    $invoker->undo();

    echo $editor->getContent() . "\n"; 

